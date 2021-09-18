<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionStatusTypes;
use AppBundle\Entity\Interfaces\IEntity;
use AppBundle\Entity\Traits\EntityTrait;
use AppBundle\Entity\Traits\WithEntityId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="transactions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "TRANSFER" = "AppBundle\Entity\Transfer",
 *      "DEPOSIT" = "AppBundle\Entity\Deposit"
 * })
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Transaction implements IEntity
{
    use WithEntityId, EntityTrait;

    /**
     * @var float
     * @ORM\Column(name="value", type="float")
     * @Assert\NotNull(message="Informe o valor da transação")
     */
    private $value;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;

    /**
     * @var Wallet
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Wallet", inversedBy="transactions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     */
    private $wallet;

    public function __construct()
    {
        $this->__init();
        $this->status = TransactionStatusTypes::get(TransactionStatusTypes::PENDING)->getValue();
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Transaction
     */
    public function setValue(float $value): Transaction
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Transaction
     */
    public function setStatus(string $status): Transaction
    {
        $this->status = $status;
        return $this;
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
     * @return Transaction
     */
    public function setWallet(Wallet $wallet): Transaction
    {
        $this->wallet = $wallet;
        return $this;
    }
}