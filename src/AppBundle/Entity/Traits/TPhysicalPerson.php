<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraint as AssertBase;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;


trait TPhysicalPerson
{
    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", length=11, nullable=true)
     * @Assert\NotBlank(message="Informe o CPF!")
     * @AssertBase\CpfCnpj(cpf=true, whenNull=false, message="O CPF '{{ value }}' é inválido!")
     * @Serializer\Expose()
     */
    private $cpf;

    /**
     * @return string
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * @param string|null $cpf
     * @return $this
     */
    public function setCpf(?string $cpf): TPhysicalPerson
    {
        $this->cpf = $cpf;
        return $this;
    }
}