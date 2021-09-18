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
use AppBundle\Middleware\CheckIfPayerAndPayeeIsEqualMiddleware;
use AppBundle\Middleware\CheckIfUserCanSendMoneyMiddleware;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroMiddleware;
use AppBundle\Middleware\CheckIfWalletHasAvailableValueMiddleware;
use AppBundle\Middleware\CheckIfWalletIsNotNullMiddleware;
use AppBundle\Middleware\CheckPaymentServiceAuthorizationMiddleware;
use AppBundle\Middleware\Middleware;
use Doctrine\ORM\OptimisticLockException;

class TransferService extends TransactionService
{
    /**
     * @param IUserTransaction $payee
     * @param float $value
     * @return Middleware
     */
    protected function getTransferMiddlewares(IUserTransaction $payee, float $value): Middleware
    {
        $middleware = new CheckIfWalletIsNotNullMiddleware($this->wallet);
        $middleware
            ->linkWith(new CheckIfPayerAndPayeeIsEqualMiddleware($this->walletOwner, $payee))
            ->linkWith(new CheckIfValueGreaterEqualThanZeroMiddleware($value))
            ->linkWith(new CheckIfUserCanSendMoneyMiddleware($this->walletOwner))
            ->linkWith(new CheckIfWalletHasAvailableValueMiddleware($this->wallet, $value))
            ->linkWith(new CheckPaymentServiceAuthorizationMiddleware())
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