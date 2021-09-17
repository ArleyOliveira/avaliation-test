<?php

namespace AppBundle\Entity\Interfaces;

use stdClass;

interface IEntity
{
    public function toArray(): array;
    public function toStdClass(): stdClass;
}