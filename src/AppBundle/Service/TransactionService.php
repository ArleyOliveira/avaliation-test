<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroValidator;
use AppBundle\Middleware\CheckIfWalletIsNotNullValidator;
use AppBundle\Middleware\Validator;
use AppBundle\Notification\TransactionNotify;

abstract class TransactionService extends AbstractService
{
    /**
     * @var IUserTransaction
     */
    protected $walletOwner;

    /**
     * @var Wallet
     */
    protected $wallet;

    /**
     * @param Transaction $transaction
     */
    abstract protected function confirm(Transaction $transaction);

    /**
     * @param IUserTransaction $walletOwner
     */
    public function attachWalletOwner(IUserTransaction $walletOwner)
    {
        $this->walletOwner = $walletOwner;
        $this->wallet = $this->walletOwner->getWallet();
    }

    /**
     * @return CheckIfWalletIsNotNullValidator
     */
    protected function getTransactionMiddlewares(float $value): Validator
    {
        $middleware = new CheckIfWalletIsNotNullValidator($this->wallet);
        $middleware->linkWith(new CheckIfValueGreaterEqualThanZeroValidator($value));
        return $middleware;
    }

    /**
     * @param Transaction $transaction
     */
    protected function notify(Transaction $transaction) {
        TransactionNotify::notify($transaction);
    }

}