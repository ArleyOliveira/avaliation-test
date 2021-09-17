<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Traits\LegalPersonTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="legal_users")
 * @ORM\Entity()
 * @UniqueEntity(fields={"cnpj"}, message="Já existe o CNPJ já cadastrado!")
 * @Serializer\ExclusionPolicy("all")
 */
class LegalUser extends PersonUser
{
    use LegalPersonTrait;

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::LEGAL_USER;
    }
}