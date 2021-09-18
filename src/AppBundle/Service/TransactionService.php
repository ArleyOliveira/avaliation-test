<?php

namespace AppBundle\Service;

use AppBundle\Constants\TransactionStatusTypes;
use AppBundle\Entity\Deposit;
use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\PersonUser;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Transfer;
use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfWalletIsNotNullMiddleware;
use AppBundle\Middleware\Middleware;
use Doctrine\ORM\OptimisticLockException;

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
     * @param IUserTransaction $user
     */
    public function attachWalletOwner(IUserTransaction $user)
    {
        $this->walletOwner = $user;
        $this->wallet = $this->walletOwner->getWallet();
    }

    /**
     * @return CheckIfWalletIsNotNullMiddleware
     */
    protected function getTransactionMiddlewares(): Middleware
    {
        return new CheckIfWalletIsNotNullMiddleware($this->wallet);
    }

    /**
     * @param Transaction $transaction
     */
    abstract protected function confirm(Transaction $transaction);

}