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
use AppBundle\Validator\CheckIfPayerAndPayeeIsEqualValidator;
use AppBundle\Validator\CheckIfUserCanSendMoneyValidator;
use AppBundle\Validator\CheckIfValueGreaterEqualThanZeroValidator;
use AppBundle\Validator\CheckIfWalletHasAvailableValueValidator;
use AppBundle\Validator\CheckIfWalletIsNotNullValidator;
use AppBundle\Validator\CheckPaymentServiceAuthorizationValidator;
use AppBundle\Validator\Validator;
use Doctrine\ORM\OptimisticLockException;

class TransferService extends TransactionService
{
    /**
     * @param IUserTransaction $payee
     * @param float $value
     * @return Validator
     */
    protected function getTransferValidators(IUserTransaction $payee, float $value): Validator
    {
        $validator = new CheckIfWalletIsNotNullValidator($this->wallet);
        $validator
            ->linkWith(new CheckIfPayerAndPayeeIsEqualValidator($this->walletOwner, $payee))
            ->linkWith(new CheckIfValueGreaterEqualThanZeroValidator($value))
            ->linkWith(new CheckIfUserCanSendMoneyValidator($this->walletOwner))
            ->linkWith(new CheckIfWalletHasAvailableValueValidator($this->wallet, $value))
            ->linkWith(new CheckPaymentServiceAuthorizationValidator())
        ;

        return $validator;
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
        $validators = $this->getTransferValidators($payee, $value);
        $validators->check();

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