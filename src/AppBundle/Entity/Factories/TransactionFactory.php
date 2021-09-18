<?php

namespace AppBundle\Entity\Factories;

use AppBundle\Entity\Deposit;
use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\Transfer;
use AppBundle\Entity\Wallet;

abstract class TransactionFactory
{
    public static function createDeposit(Wallet $wallet, float $value): Deposit
    {
        $transaction = new Deposit();
        $transaction->setValue($value);

        $wallet->addTransaction($transaction);

        return $transaction;
    }

    public static function createTransfer(Wallet $wallet, IUserTransaction $payee, float $value): Transfer
    {
        $transaction = new Transfer();
        $transaction->setValue($value);
        $transaction->setPayee($payee);

        $wallet->addTransaction($transaction);

        return $transaction;
    }
}