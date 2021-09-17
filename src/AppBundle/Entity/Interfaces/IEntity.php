<?php

namespace AppBundle\Entity\Interfaces;

use DateTime;
use stdClass;

interface IEntity
{

    public function setActive(?bool $active): void;
    public function isActive(): ?bool;

    public function getCreated(): DateTime;
    public function getUpdated(): DateTime;

    public function toArray(): array;
    public function toStdClass(): stdClass;

}