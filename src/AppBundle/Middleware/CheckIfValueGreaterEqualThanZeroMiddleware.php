<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidTransactionException;

class CheckIfValueGreaterEqualThanZeroMiddleware extends Middleware
{
    /**
     * @var float
     */
    private $value;

    /**
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        if ($this->value <= 0) {
            throw ExceptionFactory::create(
                InvalidTransactionException::class,
                "O valor da transação não pode ser menor ou igual a zero!"
            );
        }

        return $this->checkNext();
    }
}