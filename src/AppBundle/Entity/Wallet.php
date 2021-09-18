<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Entity\Traits\EntityTrait;
use AppBundle\Entity\Traits\WithEntityId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wallets")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WalletRepository")
 */
class Wallet implements IEntity
{
    use WithEntityId, EntityTrait;

    /**
     * @var float
     * @ORM\Column(name="available_value", type="float", nullable=false, options={"default": 0})
     */
    private $availableValue;

    /**
     * @var PersonUser
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\PersonUser", inversedBy="wallet")
     * @ORM\JoinColumn(name="person_user_id", referencedColumnName="id")
     */
    private $personUser;

    public function __construct()
    {
        $this->__init();
        $this->availableValue = 0.00;
    }

    /**
     * @return float
     */
    public function getAvailableValue(): float
    {
        return $this->availableValue;
    }

    /**
     * @param float $availableValue
     * @return Wallet
     */
    public function setAvailableValue(float $availableValue): Wallet
    {
        $this->availableValue = $availableValue;
        return $this;
    }

    /**
     * @return PersonUser
     */
    public function getPersonUser(): PersonUser
    {
        return $this->personUser;
    }

    /**
     * @param PersonUser $personUser
     * @return Wallet
     */
    public function setPersonUser(PersonUser $personUser): Wallet
    {
        $this->personUser = $personUser;
        return $this;
    }
}