<?php

namespace AppBundle\Service\Factories;

use AppBundle\Service\Gateway\PaymentAuthorizerService;
use AppBundle\Service\Http\ClientHttpService;

abstract class PaymentAuthorizerServiceFactory
{
    /**
     * @return PaymentAuthorizerService
     */
    public static function create(): PaymentAuthorizerService {
        $clientHttp = new ClientHttpService();
        return new PaymentAuthorizerService($clientHttp);
    }
}