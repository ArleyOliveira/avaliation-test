<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Rest\Route("", name="transaction", methods={"POST"})
     */
    public function transactionAction(Request $request) {
        return;
    }
}