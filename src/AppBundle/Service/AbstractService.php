<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;

abstract class AbstractService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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

}