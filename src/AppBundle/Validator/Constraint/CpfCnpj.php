<?php

namespace AppBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CpfCnpj extends Constraint
{
    public $cpf      = false;
    public $cnpj     = false;
    public $whenNull = true;
    public $message  = 'O {{ type }} informado é inválido.';
}