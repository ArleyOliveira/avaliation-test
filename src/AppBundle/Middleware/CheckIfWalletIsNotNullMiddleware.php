<?php

namespace AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidTransactionException;

class CheckIfWalletIsNotNullMiddleware extends Middleware
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @param Wallet|null $wallet
     */
    public function __construct(Wallet $wallet = null)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        if (!$this->wallet) {
            throw ExceptionFactory::create(
                InvalidTransactionException::class,
                "A carteira da transação não foi informada!"
            );
        }

        return $this->checkNext();
    }
}