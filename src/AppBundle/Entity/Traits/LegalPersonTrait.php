<?php

namespace AppBundle\Entity\Traits;

use AppBundle\Utils\TreatText;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraint as AssertBase;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

trait LegalPersonTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=14, nullable=true)
     * @Assert\NotBlank(message="Informe o CNPJ")
     * @AssertBase\CpfCnpj(cnpj=true, whenNull=false, message="O CNPJ '{{ value }}' é inválido!")
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
    public function setCnpj(?string $cnpj): LegalPersonTrait
    {
        $this->cnpj = TreatText::onlyNumber($cnpj);
        return $this;
    }
}