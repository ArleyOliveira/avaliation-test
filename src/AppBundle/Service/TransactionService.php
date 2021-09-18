<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroMiddleware;
use AppBundle\Middleware\CheckIfWalletIsNotNullMiddleware;
use AppBundle\Middleware\Middleware;

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
        $middleware->linkWith(new CheckIfValueGreaterEqualThanZeroMiddleware($value));
        return $middleware;
    }

    /**
     * @param Transaction $transaction
     */
    abstract protected function confirm(Transaction $transaction);

}