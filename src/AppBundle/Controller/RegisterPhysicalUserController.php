<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Traits\WithService;
use AppBundle\Entity\PhysicalUser;
use AppBundle\Form\Type\PhysicalUserType;
use AppBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/register/physical-user")
 */
class RegisterPhysicalUserController extends AbstractController
{
    use WithService;

    public function initialize(): void
    {
        $this->attachRepositoryToService(
            $this->getUserService(),
            $this->getDoctrine()->getRepository(PhysicalUser::class)
        );
    }

    /**
     * @Route("", name="register_physical_user", methods={"POST"})
     */
    public function registerAction(Request $request)
    {
        $physicalUser = new PhysicalUser();
        $form = $this->createForm(PhysicalUserType::class, $physicalUser, [
            'csrf_protection' => false
        ]);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            return new JsonResponse($physicalUser->toArray());
        } else {
            return new JsonResponse($this->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @return UserService|object
     */
    private function getUserService() {
        return $this->get('user.service');
    }
}