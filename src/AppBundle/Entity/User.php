<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Interfaces\IUser;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="`users`")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "PERSON_USER" = "AppBundle\Entity\PersonUser"
 * })
 * @UniqueEntity(fields={"email"}, message="Já existe um usuário com este e-mail cadastrado!")
 * @ORM\HasLifecycleCallbacks()
 */
abstract class User extends BaseUser implements IUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    abstract public function getType(): string;
}