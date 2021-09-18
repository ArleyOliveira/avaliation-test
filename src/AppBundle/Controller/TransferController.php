<?php

namespace AppBundle\Controller;

use AppBundle\Service\TransferService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class TransferController extends AbstractController
{
    public function initialize(): void
    {
        $this->attachToService($this->getTransferService(),
            array('attachWalletOwner' => $this->getUser())
        );
    }

    /**
     * @Route("/transfer", name="transfer_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {

            $payeeId = (int)$request->request->get('payee', null);
            $value = (float)$request->request->get('value', 0);

            $transaction = $this->service->handleTransfer($payeeId, $value);

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
     * @return TransferService|object
     */
    private function getTransferService()
    {
        return $this->get('transfer.service');
    }
}