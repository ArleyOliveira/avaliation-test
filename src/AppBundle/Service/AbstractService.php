<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Repository\AbstractRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;

abstract class AbstractService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param AbstractRepository $repository
     */
    public function attachRepository(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param IEntity $entity
     * @throws OptimisticLockException
     */
    protected function persist(IEntity $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

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