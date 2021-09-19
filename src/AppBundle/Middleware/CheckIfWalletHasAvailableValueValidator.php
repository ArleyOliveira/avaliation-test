<?php

namespace AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidTransactionException;

class CheckIfWalletHasAvailableValueValidator extends Validator
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var float
     */
    private $requestValue;

    /**
     * @param Wallet $wallet
     * @param float $requestValue
     */
    public function __construct(Wallet $wallet, float $requestValue)
    {
        $this->wallet = $wallet;
        $this->requestValue = $requestValue;
    }


    public function check(): bool
    {
        if ($this->requestValue > $this->wallet->getAvailableValue()) {
            throw ExceptionFactory::create(
                InvalidTransactionException::class,
                "Saldo indisponível!"
            );
        }

        return $this->checkNext();
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @return float
     */
    public function getRequestValue(): float
    {
        return $this->requestValue;
    }
}