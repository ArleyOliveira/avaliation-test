<?php

namespace AppBundle\Service;

use AppBundle\Constants\TransactionStatusTypes;
use AppBundle\Entity\Deposit;
use AppBundle\Entity\Factories\TransactionFactory;
use AppBundle\Entity\Transaction;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Validator\Validator;
use Doctrine\ORM\OptimisticLockException;

class DepositService extends TransactionService
{
    /**
     * @param float $value
     * @return Validator
     */
    protected function getDepositValidators(float $value): Validator
    {
        return $this->getTransactionValidators($value);
    }

    /**
     * @param float $value
     * @return Deposit
     * @throws AbstractException
     * @throws OptimisticLockException
     */
    public function deposit(float $value): Deposit
    {
        $validators = $this->getDepositValidators($value);
        $validators->check();

        $transaction = TransactionFactory::createDeposit($this->wallet, $value);
        $this->confirm($transaction);

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @throws OptimisticLockException
     */
    protected function confirm(Transaction $transaction)
    {
        $wallet = $transaction->getWallet();
        $wallet->addValue($transaction->getValue());

        $transaction->setStatus(TransactionStatusTypes::get(TransactionStatusTypes::CONFIRMED)->getName());

        $this->persist($wallet);

        $this->notify($transaction);
    }

}