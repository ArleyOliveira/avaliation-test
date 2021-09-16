<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraint as AssertBase;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

trait TLegalPerson
{
    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=14, nullable=true)
     * @Assert\NotBlank(message="Informe o CNPJ")
     * @AssertBase\CpfCnpj(cnpj=true)
     * @Serializer\Expose()
     */
    private $cnpj;

    /**
     * @return string
     */
    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    /**
     * @param string|null $cnpj
     * @return $this
     */
    public function setCnpj(?string $cnpj): TLegalPerson
    {
        $this->cnpj = $cnpj;
        return $this;
    }
}