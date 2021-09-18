<?php

namespace AppBundle\Entity\Interfaces;

use AppBundle\Entity\Wallet;

interface IUserTransaction
{
    /**
     * @return Wallet
     */
    public function getWallet(): Wallet;
}