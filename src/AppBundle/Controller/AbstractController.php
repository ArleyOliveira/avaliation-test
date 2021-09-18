<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Traits\WithService;
use AppBundle\Exceptions\AbstractException;
use AppBundle\Exceptions\Http\AbstractHttpException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends Controller
{
    use WithService;

    public function handleError(Exception $e): array
    {
        $response['message'] = $e->getMessage();
        $response['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof AbstractException) {

            $response['statusCode'] = Response::HTTP_BAD_REQUEST;

            if ($e->getDetails()) {
                $response['details'] = $e->getDetails();
            }

            if ($e instanceof AbstractHttpException && $e->getStatusCode()) {
                $response['statusCode'] = $e->getStatusCode();
            }
        }

        return $response;
    }
}