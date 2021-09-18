<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionTypes;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="transfers")
 * @ORM\Entity()
 */
class Transfer extends Transaction
{
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