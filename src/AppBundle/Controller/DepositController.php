<?php

namespace AppBundle\Controller;

use AppBundle\Service\DepositService;
use Exception;
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
        $this->attachToService($this->getDepositService(),
            array('attachWalletOwner' => $this->getUser())
        );
    }

    /**
     * @Route("", name="deposit_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $value = (float)$request->request->get('value', 0);

            $transaction = $this->service->deposit($value);

            $em->getConnection()->commit();

            $responseData = $transaction->toArray();
            $statusCode = Response::HTTP_OK;
        } catch (Exception $e) {
            $em->getConnection()->rollBack();

            $responseData = $this->handleError($e);
            $statusCode = $responseData['statusCode'];
        }
        return new JsonResponse($responseData, $statusCode);
    }

    /**
     * @return DepositService|object
     */
    public function getDepositService()
    {
        return $this->get('deposit.service');
    }
}