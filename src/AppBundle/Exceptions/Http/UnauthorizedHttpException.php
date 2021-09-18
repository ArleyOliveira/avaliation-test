<?php

namespace AppBundle\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedHttpException extends AbstractHttpException
{
    protected $statusCode = Response::HTTP_UNAUTHORIZED;
}