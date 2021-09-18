<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Traits\EntityTrait;
use AppBundle\Entity\Traits\PersonTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonUserRepository")
 * @ORM\Table(name="person_users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "PHISICAL_USER" = "AppBundle\Entity\PhysicalUser",
 *      "LEGAL_USER"    = "AppBundle\Entity\LegalUser"
 * })
 * @ORM\HasLifecycleCallbacks()
 */
abstract class PersonUser extends User
{
    use  PersonTrait, EntityTrait;


    public function __construct()
    {
        parent::__construct();
        $this
            ->setEnabled(true)
            ->setRoles(['ROLE_USER'])
            ->setSuperAdmin(false);

        $this->active = true;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    public function getType(): string
    {
        return UserTypes::PERSON_USER;
    }
}