<?php

namespace AppBundle\Form\Serializes;

use Symfony\Component\Form\FormInterface;

class FormErrorSerializer
{
    public static function serialize(FormInterface $form): array {

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
                if ($child_err = self::serialize($child)) {
                    $errors[$key] = $child_err;
                }
            }
        }

        return $errors;
    }
}