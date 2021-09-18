<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionTypes;
use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Entity\Traits\EntityTrait;
use AppBundle\Entity\Traits\WithEntityId;
use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @var ArrayCollection|Transaction[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Wallet", mappedBy="wallet", cascade={"persist", "remove"})
     */
    private $transactions;

    public function __construct()
    {
        $this->__init();
        $this->availableValue = 0.00;
        $this->transactions = new ArrayCollection();
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

    /**
     * @return Transaction[]|ArrayCollection
     */
    public function getTransactions(): ArrayCollection
    {
        return $this->transactions;
    }

    /**
     * @param Transaction[]|ArrayCollection $transactions
     * @return Wallet
     */
    public function setTransactions(ArrayCollection $transactions): Wallet
    {
        $this->transactions = $transactions;
        return $this;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function addTransaction(Transaction $transaction): Wallet {
        $this->transactions->add($transaction);
        $transaction->setWallet($this);
        return $this;
    }

    /**
     * @param float $value
     */
    public function addValue(float $value) {
        $this->availableValue += $value;
    }

    /**
     * @param float $value
     */
    public function removeValue(float $value) {
        $this->availableValue -= $value;
    }
}