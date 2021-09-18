<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionTypes;
use AppBundle\Entity\Interfaces\IUserTransaction;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="transfers")
 * @ORM\Entity()
 */
class Transfer extends Transaction
{
    /**
     * @var IUserTransaction
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PersonUser")
     * @ORM\JoinColumn(name="payee_id", referencedColumnName="id")
     * @Assert\NotNull(message="Informe o beneficiário da transação")
     * @Serializer\Exclude()
     */
    private $payee;

    /**
     * @return string
     */
    public function getType(): string
    {
       return TransactionTypes::TRANSFER;
    }

    /**
     * @return IUserTransaction
     */
    public function getPayee(): ?IUserTransaction
    {
        return $this->payee;
    }

    /**
     * @param IUserTransaction $payee
     * @return $this
     */
    public function setPayee(IUserTransaction $payee): Transfer
    {
        $this->payee = $payee;

        return $this;
    }
}