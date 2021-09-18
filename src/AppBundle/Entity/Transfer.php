<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionTypes;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="transfers")
 * @ORM\Entity()
 */
class Transfer extends Transaction
{
    /**
     * @var PersonUser
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PersonUser")
     * @ORM\JoinColumn(name="payee_id", referencedColumnName="id")
     * @Assert\NotNull(message="Informe o beneficiário da transação")
     */
    private $payee;

    /**
     * @var Wallet
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Wallet")
     * @ORM\JoinColumn(name="wallet_received_id", referencedColumnName="id")
     */
    private $walletReceived;

    /**
     * @return string
     */
    public function getType(): string
    {
       return TransactionTypes::TRANSFER;
    }

    /**
     * @return PersonUser
     */
    public function getPayee(): ?PersonUser
    {
        return $this->payee;
    }

    /**
     * @param PersonUser|null $payee
     * @return $this
     */
    public function setPayee(?PersonUser $payee): Transfer
    {
        $this->payee = $payee;
        return $this;
    }

    /**
     * @return Wallet
     */
    public function getWalletReceived(): Wallet
    {
        return $this->walletReceived;
    }

    /**
     * @param Wallet $walletReceived
     * @return Transfer
     */
    public function setWalletReceived(Wallet $walletReceived): Transfer
    {
        $this->walletReceived = $walletReceived;
        return $this;
    }

}