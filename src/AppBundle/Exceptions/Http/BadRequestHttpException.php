<?php

namespace AppBundle\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

class BadRequestHttpException extends AbstractHttpException
{
    protected $statusCode = Response::HTTP_BAD_REQUEST;
}