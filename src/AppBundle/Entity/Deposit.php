<?php

namespace AppBundle\Entity;

use AppBundle\Constants\TransactionTypes;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="deposits")
 * @ORM\Entity()
 */
class Deposit extends Transaction
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return TransactionTypes::DEPOSIT;
    }
}