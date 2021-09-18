<?php

namespace AppBundle\Entity\Factories;

use AppBundle\Entity\Deposit;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;

abstract class TransactionFactory
{
    public static function createDeposit(Wallet $wallet, float $value): Transaction
    {
        $transaction = new Deposit();
        $transaction->setValue($value);

        $wallet->addTransaction($transaction);

        return $transaction;
    }
}