<?php

namespace AppBundle\Service\Traits;

use AppBundle\Repository\AbstractRepository;

trait WithRepository
{
    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @param AbstractRepository $repository
     */
    public function attachRepository(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }
}