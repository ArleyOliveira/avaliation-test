<?php

namespace AppBundle\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpException extends AbstractHttpException
{
    protected $statusCode = Response::HTTP_NOT_FOUND;
}