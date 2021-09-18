<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\InvalidUserException;
use AppBundle\Repository\PersonUserRepository;

class CheckExistPhysicalUserByCpf extends CheckExistUser
{
    /**
     * @var string
     */
    private $cpf;

    /**
     * @param string $columnName
     * @param string $cpf
     * @param int|null $ignoreUserId
     * @param PersonUserRepository $repository
     */
    public function __construct(string $columnName, string $cpf, ?int $ignoreUserId, PersonUserRepository $repository)
    {
        parent::__construct($columnName, $ignoreUserId, $repository);
        $this->cpf = $cpf;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        $user = $this->repository->findOneBy([$this->columnName => $this->cpf]);

        if (null !== $user && $user->getId() !== $this->ignoreUserId) {
            throw ExceptionFactory::create(
                InvalidUserException::class,
                "Já existe um usuário com este CPF ({$this->cpf}) cadastrado!"
            );
        }

        return $this->checkNext();
    }

    /**
     * @param string $cpf
     * @return CheckExistPhysicalUserByCpf
     */
    public function setCpf(string $cpf): CheckExistPhysicalUserByCpf
    {
        $this->cpf = $cpf;
        return $this;
    }
}