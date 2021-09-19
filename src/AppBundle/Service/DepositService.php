<?php

namespace AppBundle\Service;

use AppBundle\Constants\TransactionStatusTypes;
use AppBundle\Entity\Deposit;
use AppBundle\Entity\Factories\TransactionFactory;
use AppBundle\Entity\Transaction;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroValidator;
use AppBundle\Middleware\Validator;
use Doctrine\ORM\OptimisticLockException;

class DepositService extends TransactionService
{
    /**
     * @param float $value
     * @return Validator
     */
    protected function getDepositMiddlewares(float $value): Validator
    {
        return $this->getTransactionMiddlewares($value);
    }

    /**
     * @param float $value
     * @return Deposit
     * @throws AbstractException
     * @throws OptimisticLockException
     */
    public function deposit(float $value): Deposit
    {
        $middlewares = $this->getDepositMiddlewares($value);
        $middlewares->check();

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