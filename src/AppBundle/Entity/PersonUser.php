<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Interfaces\IPerson;
use AppBundle\Entity\Traits\TEntity;
use AppBundle\Entity\Traits\TPerson;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="person_users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "PHISICAL_USER" = "AppBundle\Entity\PhysicalUser",
 *      "LEGAL_USER"    = "AppBundle\Entity\LegalUser"
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class PersonUser extends User implements IPerson
{
    use  TPerson, TEntity;

    public function getType(): string
    {
        return UserTypes::PERSON_USER;
    }
}