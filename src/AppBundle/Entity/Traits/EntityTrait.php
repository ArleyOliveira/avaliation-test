<?php

namespace AppBundle\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Expression\ExpressionEvaluator;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use stdClass;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use function json_decode;
use function json_encode;

trait EntityTrait
{
    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default": true})
     */
    private $active;

    /**
     * @var DateTime $created
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime<'Y-m-d\TH:i:s'>")
     */
    private $created;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime<'Y-m-d\TH:i:s'>")
     */
    private $updated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->active = true;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdated()
    {
        $this->updated = new DateTime('now');
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return array|mixed
     */
    public function toArray(): array
    {
        return $this->getSerializer()->toArray($this, SerializationContext::create()->enableMaxDepthChecks());
    }

    /**
     * @return stdClass
     */
    public function toStdClass(): stdClass
    {
        return json_decode(json_encode($this->toArray()));
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    protected function getSerializer(): \JMS\Serializer\Serializer
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new SerializedNameAnnotationStrategy(
                    new IdenticalPropertyNamingStrategy()
                )
            )
            ->setExpressionEvaluator(new ExpressionEvaluator(new ExpressionLanguage()))
            ->build();
    }
}