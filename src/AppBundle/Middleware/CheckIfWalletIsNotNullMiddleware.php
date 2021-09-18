<?php

namespace AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidTransactionException;

class CheckIfWalletIsNotNullMiddleware extends Middleware
{
    const MESSAGE = "A carteira da transação não foi informada!";

    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var string
     */
    private $message;

    /**
     * @param Wallet|null $wallet
     */
    public function __construct(Wallet $wallet = null, string $message = self::MESSAGE)
    {
        $this->wallet = $wallet;
        $this->message = $message;
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
                $this->message
            );
        }

        return $this->checkNext();
    }
}