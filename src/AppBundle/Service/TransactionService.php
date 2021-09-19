<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Middleware\CheckIfValueGreaterThanZeroMiddleware;
use AppBundle\Middleware\CheckIfWalletIsNotNullMiddleware;
use AppBundle\Middleware\Middleware;
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
     * @return CheckIfWalletIsNotNullMiddleware
     */
    protected function getTransactionMiddlewares(float $value): Middleware
    {
        $middleware = new CheckIfWalletIsNotNullMiddleware($this->wallet);
        $middleware->linkWith(new CheckIfValueGreaterThanZeroMiddleware($value));
        return $middleware;
    }

    /**
     * @param Transaction $transaction
     */
    protected function notify(Transaction $transaction) {
        TransactionNotify::notify($transaction);
    }

}