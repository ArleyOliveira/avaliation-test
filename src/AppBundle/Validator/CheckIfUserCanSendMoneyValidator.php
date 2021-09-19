<?php

namespace AppBundle\Validator;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\LegalUser;
use AppBundle\Entity\PersonUser;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidUserException;

class CheckIfUserCanSendMoneyValidator extends Validator
{
    /**
     * @var PersonUser
     */
    private $user;

    /**
     * @param PersonUser $user
     */
    public function __construct(IUserTransaction $user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        if ($this->user instanceof LegalUser) {
            throw ExceptionFactory::create(
                InvalidUserException::class,
                "Este usuário não pode enviar dinheiro!"
            );
        }

        return $this->checkNext();
    }

    /**
     * @return PersonUser
     */
    public function getUser(): PersonUser
    {
        return $this->user;
    }
}