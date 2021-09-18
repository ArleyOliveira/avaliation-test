<?php

namespace AppBundle\Entity;

use AppBundle\Constants\UserTypes;
use AppBundle\Entity\Traits\EntityTrait;
use AppBundle\Entity\Traits\PersonTrait;
use AppBundle\Form\Type\PersonUserType;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\SerializationContext;

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
class PersonUser extends User
{
    use  PersonTrait, EntityTrait;

    /**
     * @var Wallet
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Wallet", mappedBy="personUser", cascade={"persist", "remove"})
     * @Serializer\Expose()
     */
    private $wallet;

    public function __construct()
    {
        parent::__construct();
        $this->__init();

        $this->wallet = new Wallet();
        $this->wallet->setPersonUser($this);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return UserTypes::PERSON_USER;
    }

    /**
     * @return string
     */
    public function getFormTypeClass(): string
    {
        return PersonUserType::class;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     * @return PersonUser
     */
    public function setWallet(Wallet $wallet): PersonUser
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function toArray(): array
    {
        $array = $this->getSerializer()->toArray($this, SerializationContext::create()->enableMaxDepthChecks());

        unset($array['password']);

        return $array;
    }
}