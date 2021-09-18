<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidUserException;
use AppBundle\Repository\PersonUserRepository;

class CheckExistUserByEmailMiddleware extends CheckExistUserMiddleware
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $columnName
     * @param string $cpf
     * @param int|null $ignoreUserId
     * @param PersonUserRepository $repository
     */
    public function __construct(string $columnName, string $cpf, ?int $ignoreUserId, PersonUserRepository $repository)
    {
        parent::__construct($columnName, $ignoreUserId, $repository);
        $this->email = $cpf;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        $user = $this->repository->findOneBy([$this->columnName => $this->email]);

        if (null !== $user && $user->getId() !== $this->ignoreUserId) {
            throw ExceptionFactory::create(
                InvalidUserException::class,
                "Já existe um usuário com este e-mail ({$this->email}) cadastrado!"
            );
        }

        return $this->checkNext();
    }

    /**
     * @param string $email
     * @return CheckExistUserByEmailMiddleware
     */
    public function setEmail(string $email): CheckExistUserByEmailMiddleware
    {
        $this->email = $email;
        return $this;
    }
}