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
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use function json_decode;
use function json_encode;

trait TEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @Serializer\Exclude()
     */
    private $created;

    /**
     * @var DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Serializer\Exclude()
     */
    private $updated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TEntity
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function __construct()
    {
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
     * @return TEntity
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @return $this
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdated()
    {
        $this->updated = new DateTime('now');
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function toArray()
    {
        return $this->getSerializer()->toArray($this, SerializationContext::create()->enableMaxDepthChecks());
    }

    /**
     * @return object
     */
    public function toStdClass()
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