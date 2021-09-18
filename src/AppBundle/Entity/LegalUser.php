<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Traits\LegalPersonTrait;
use AppBundle\Form\Type\LegalUserType;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="legal_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LegalUserRepository")
 */
class LegalUser extends PersonUser
{
    use LegalPersonTrait;

    /**
     * @return string
     */
    public function getFormTypeClass(): string
    {
        return LegalUserType::class;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::LEGAL_USER;
    }

}