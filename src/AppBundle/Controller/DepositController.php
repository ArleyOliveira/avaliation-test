<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/deposit")
 */
class DepositController extends AbstractController
{

    public function initialize(): void
    {
        // TODO: Implement initialize() method.
    }

    /**
     * @Route("", name="deposit_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {

    }
}