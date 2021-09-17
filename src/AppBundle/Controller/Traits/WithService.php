<?php

namespace AppBundle\Controller\Traits;

use AppBundle\Repository\AbstractRepository;
use AppBundle\Service\AbstractService;

trait WithService
{
    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * @param AbstractService $service
     * @param AbstractRepository $repository
     */
    protected function attachRepositoryToService(AbstractService $service, AbstractRepository $repository) {
        $this->service = $service;
        $service->attachRepository($repository);
    }
}