<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Service\Traits\WithRepository;
use Doctrine\ORM\OptimisticLockException;

abstract class AbstractEntityService extends AbstractService
{
    use  WithRepository;

    /**
     * @return array
     */
    public function index(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $data
     */
    abstract public function create(array $data): IEntity;

    /**
     * @param IEntity $entity
     * @param array $data
     */
    abstract public function update(IEntity $entity, array $data): IEntity;

    /**
     * @param IEntity $entity
     * @throws OptimisticLockException
     */
    private function inactive(IEntity $entity)
    {
        $entity->setActive(false);
        $this->persist($entity);
    }
}