<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        return new JsonResponse([
            "OK" => true
        ], 200);
    }
}