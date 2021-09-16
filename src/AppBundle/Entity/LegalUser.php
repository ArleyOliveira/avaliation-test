<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Interfaces\IPerson;
use AppBundle\Entity\Traits\TLegalPerson;
use AppBundle\Entity\Traits\TPerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="legal_users")
 * @ORM\Entity()
 * @Serializer\ExclusionPolicy("all")
 * @UniqueEntity(fields={"email"}, message="E-mail já cadastrado!")
 * @UniqueEntity(fields={"cnpj"}, message="CPF já cadastrado!")
 */
class LegalUser extends User implements IPerson
{
    use TPerson, TLegalPerson;

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::LEGAL_USER;
    }
}