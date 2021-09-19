<?php

namespace AppBundle\Service\Interfaces;

interface IPaymentAuthorizerService
{
    /**
     * @return bool
     */
    public function isAuthorized(): bool;
}