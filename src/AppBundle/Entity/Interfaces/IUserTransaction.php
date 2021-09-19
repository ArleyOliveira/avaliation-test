<?php

namespace AppBundle\Entity\Interfaces;

use AppBundle\Entity\Wallet;

interface IUserTransaction
{

    public function getId();

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet;
}