<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Traits\WithService;
use AppBundle\Entity\PersonUser;
use AppBundle\Entity\PhysicalUser;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\UserService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @Route("/register/physical-user")
 */
class RegisterPhysicalUserController extends AbstractController
{
    use WithService;

    public function initialize(): void
    {
        $this->attachToService(
            $this->getUserService(),
            array('attachRepository' => $this->getDoctrine()->getRepository(PersonUser::class)),
            array('attachFormFactory' => $this->get('form.factory')),
            array('attachEncoderFactoryInterface' => $this->get('security.encoder_factory'))
        );
    }

    /**
     * @Route("", name="register_physical_user", methods={"POST"})
     */
    public function registerAction(Request $request)
    {
        try {
            $user = $this->service->create($request->request->all());

            $responseData = $user->toArray();
            $statusCode = Response::HTTP_OK;

        } catch (Exception $e) {
            $responseData = $this->handleError($e);
            $statusCode = $responseData['statusCode'];
        }
        return new JsonResponse($responseData, $statusCode);
    }

    /**
     * @return UserService|object
     */
    private function getUserService()
    {
        return $this->get('user.service');
    }
}