<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\Http\UnauthorizedHttpException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentServiceAuthorizationMiddleware extends Middleware
{
    const ENDPOINT = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        $client = new Client();

        $response = $client->get(self::ENDPOINT);

        $data = json_decode($response->getBody());

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $message = (isset($data->message)) ? $data->message : "Serviço autorizador do pagamento não está disponível!";

            throw ExceptionFactory::create(
                UnauthorizedHttpException::class,
                $message
            );
        }

        return $this->checkNext();
    }
}