<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Traits\PhysicalPersonTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="physical_users")
 * @ORM\Entity()
 * @UniqueEntity(fields={"cpf"}, message="Já existe o CPF cadastrado!")
 * @Serializer\ExclusionPolicy("all")
 */
class PhysicalUser extends PersonUser
{
    use PhysicalPersonTrait;

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::PHISICAL_USER;
    }
}