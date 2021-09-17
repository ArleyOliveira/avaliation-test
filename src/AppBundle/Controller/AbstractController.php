<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Traits\WithService;
use AppBundle\Entity\PhysicalUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    use WithService;

    /**
     * @param $form
     * @return array
     */
    protected function getFormErrors($form)
    {
        $errors = array();

        // get form errors first
        foreach ($form->getErrors() as $err) {
            if ($form->isRoot()) {
                $errors['__GLOBAL__'][] = $err->getMessage();
            } else {
                $errors[] = $err->getMessage();
            }
        }

        // check if form has any children
        if ($form->count() > 0) {
            // get errors from form child
            foreach ($form->getIterator() as $key => $child) {
                if ($child_err = $this->getFormErrors($child)) {
                    $errors[$key] = $child_err;
                }
            }
        }

        return $errors;
    }

}