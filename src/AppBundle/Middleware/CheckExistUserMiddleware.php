<?php

namespace AppBundle\Middleware;

use AppBundle\Repository\AbstractRepository;

abstract class CheckExistUserMiddleware extends Middleware
{
    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $columnName;

    /**
     * @var integer
     */
    protected $ignoreUserId;

    /**
     * @param string $columnName
     * @param AbstractRepository $repository
     * @param int|null $ignoreUserId
     */
    public function __construct(string $columnName, ?int $ignoreUserId, AbstractRepository $repository)
    {
        $this->columnName = $columnName;
        $this->ignoreUserId = $ignoreUserId;
        $this->repository = $repository;
    }

}