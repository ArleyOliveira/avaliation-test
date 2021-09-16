<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

trait TPerson
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=200)
     * @Assert\NotBlank(message="Informe o campo nome!")
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @var
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\NotBlank(message="Informe o campo e-mail")
     * @Assert\Email(message="O e-mail não é válido!")
     * @Serializer\Expose()
     */
    private $email;
}