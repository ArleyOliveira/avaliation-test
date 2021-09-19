<?php

namespace AppBundle\Validator;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidUserException;

class CheckIfPayerAndPayeeIsEqualsValidator extends Validator
{
    /**
     * @var IUserTransaction
     */
    private $payer;

    /**
     * @var IUserTransaction
     */
    private $payee;

    /**
     * @param IUserTransaction $payer
     * @param IUserTransaction $payee
     */
    public function __construct(IUserTransaction $payer, IUserTransaction $payee)
    {
        $this->payer = $payer;
        $this->payee = $payee;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        if ($this->payee->getId() === $this->payer->getId()) {
            throw ExceptionFactory::create(
                InvalidUserException::class,
                "Não é possível realizar transações para você mesmo!"
            );
        }
        return $this->checkNext();
    }
}