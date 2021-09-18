<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    public function initialize(): void
    {

    }

    /**
     * @Route("", name="transaction_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        return new JsonResponse([
            'OK' => true
        ], Response::HTTP_OK);
    }
}