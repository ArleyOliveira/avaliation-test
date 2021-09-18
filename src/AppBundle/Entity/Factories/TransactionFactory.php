<?php

namespace AppBundle\Entity\Factories;

use AppBundle\Entity\Deposit;
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
}