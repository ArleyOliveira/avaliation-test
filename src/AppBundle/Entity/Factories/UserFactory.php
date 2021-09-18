<?php

namespace AppBundle\Entity\Factories;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Interfaces\IUser;
use AppBundle\Entity\LegalUser;
use AppBundle\Entity\PhysicalUser;
use AppBundle\Entity\User;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidUserException;

abstract class UserFactory
{
    /**
     * @param string $userType
     * @return User
     * @throws AbstractException
     */
    public static function create(string $userType): User
    {
        switch ($userType) {
            case UserTypes::PHISICAL_USER:
                return new PhysicalUser();
            case UserTypes::LEGAL_USER:
                return new LegalUser();
            default:
                throw ExceptionFactory::create(
                    InvalidUserException::class,
                    "As informações do usuário são inválidas!"
                );
        }
    }
}