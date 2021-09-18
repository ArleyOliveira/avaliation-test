<?php

namespace AppBundle\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

class InternalServerErrorHttpException extends AbstractHttpException
{
    protected $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
}