<?php

namespace AppBundle\Service\Gateway;

use AppBundle\Service\Interfaces\IClientHttp;
use AppBundle\Service\Interfaces\IPaymentAuthorizerService;
use Symfony\Component\HttpFoundation\Response;

class PaymentAuthorizerService implements IPaymentAuthorizerService
{
    const BASE_URL = "https://run.mocky.io/v3";

    /**
     * @var IClientHttp
     */
    private $clientHttp;

    public function __construct(IClientHttp $clientHttp)
    {
        $this->clientHttp = $clientHttp;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        $responseData = $this->clientHttp->request('GET', self::BASE_URL . '/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        return ($responseData->statusCode === Response::HTTP_OK);
    }
}