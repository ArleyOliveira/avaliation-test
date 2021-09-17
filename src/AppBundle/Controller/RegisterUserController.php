<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PhysicalUser;
use AppBundle\Form\Type\PhysicalUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/register")
 */
class RegisterUserController extends AbstractController
{
    /**
     * @Route("", name="register_user", methods={"POST"})
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
}