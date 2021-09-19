<?php

namespace AppBundle\Service;

use AppBundle\Constants\TransactionStatusTypes;
use AppBundle\Entity\Factories\TransactionFactory;
use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\PersonUser;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Transfer;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\Http\NotFoundHttpException;
use AppBundle\Middleware\CheckIfPayerAndPayeeIsEqualValidator;
use AppBundle\Middleware\CheckIfUserCanSendMoneyValidator;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroValidator;
use AppBundle\Middleware\CheckIfWalletHasAvailableValueValidator;
use AppBundle\Middleware\CheckIfWalletIsNotNullValidator;
use AppBundle\Middleware\CheckPaymentServiceAuthorizationValidator;
use AppBundle\Middleware\Validator;
use Doctrine\ORM\OptimisticLockException;

class TransferService extends TransactionService
{
    /**
     * @param IUserTransaction $payee
     * @param float $value
     * @return Validator
     */
    protected function getTransferMiddlewares(IUserTransaction $payee, float $value): Validator
    {
        $middleware = new CheckIfWalletIsNotNullValidator($this->wallet);
        $middleware
            ->linkWith(new CheckIfPayerAndPayeeIsEqualValidator($this->walletOwner, $payee))
            ->linkWith(new CheckIfValueGreaterEqualThanZeroValidator($value))
            ->linkWith(new CheckIfUserCanSendMoneyValidator($this->walletOwner))
            ->linkWith(new CheckIfWalletHasAvailableValueValidator($this->wallet, $value))
            ->linkWith(new CheckPaymentServiceAuthorizationValidator())
        ;

        return $middleware;
    }

    /**
     * @param Transaction $transaction
     * @throws OptimisticLockException
     */
    protected function confirm(Transaction $transaction)
    {
        $wallet = $transaction->getWallet();
        $wallet->removeValue($transaction->getValue());

        $transaction->setStatus(TransactionStatusTypes::get(TransactionStatusTypes::CONFIRMED)->getName());

        $walletPayee = $transaction->getPayee()->getWallet();

        $walletPayee->addValue($transaction->getValue());

        $this->persist($wallet);
        $this->persist($walletPayee);

        $this->notify($transaction);
    }

    /**
     * @param IUserTransaction $payee
     * @param float $value
     * @return Transfer
     * @throws AbstractException
     * @throws OptimisticLockException
     */
    public function transfer(IUserTransaction $payee, float $value): Transfer
    {
        $middlewares = $this->getTransferMiddlewares($payee, $value);
        $middlewares->check();

        $transaction = TransactionFactory::createTransfer($this->wallet, $payee, $value);
        $this->confirm($transaction);

        return $transaction;
    }

    /**
     * @param int $payeeId
     * @param float $value
     * @return Transfer
     * @throws AbstractException
     * @throws OptimisticLockException
     */
    public function handleTransfer(int $payeeId, float $value): Transfer
    {
        $user = $this->em->getRepository(PersonUser::class)->find($payeeId);

        if ($user instanceof IUserTransaction) {
            return $this->transfer($user, $value);
        } else {
            throw ExceptionFactory::create(
                NotFoundHttpException::class,
                "Beneficiário não encontrado!"
            );
        }
    }
}