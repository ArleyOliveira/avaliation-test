<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Interfaces\IPerson;
use AppBundle\Entity\Traits\TPerson;
use AppBundle\Entity\Traits\TPhysicalPerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="physical_users")
 * @ORM\Entity()
 * @Serializer\ExclusionPolicy("all")
 * @UniqueEntity(fields={"email"}, message="E-mail já cadastrado!")
 * @UniqueEntity(fields={"cpf"}, message="CPF já cadastrado!")
 */
class PhysicalUser extends User implements IPerson
{
    use TPerson, TPhysicalPerson;

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::PHISICAL_USER;
    }
}