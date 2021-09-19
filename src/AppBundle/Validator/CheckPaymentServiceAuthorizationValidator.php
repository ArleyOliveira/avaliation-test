<?php

namespace AppBundle\Validator;

use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Factories\ExceptionFactory;
use AppBundle\Exceptions\Http\UnauthorizedHttpException;
use AppBundle\Service\Interfaces\IPaymentAuthorizerService;

class CheckPaymentServiceAuthorizationValidator extends Validator
{

    /**
     * @var IPaymentAuthorizerService
     */
    private $authorizer;

    /**
     * @param IPaymentAuthorizerService $authorizer
     */
    public function __construct(IPaymentAuthorizerService $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public function check(): bool
    {
        if (!$this->authorizer->isAuthorized()) {
            $message = "Serviço autorizador do pagamento não está disponível!";
            throw ExceptionFactory::create(
                UnauthorizedHttpException::class,
                $message
            );
        }

        return $this->checkNext();
    }
}