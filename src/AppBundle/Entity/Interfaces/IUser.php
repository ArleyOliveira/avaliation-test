<?php

namespace AppBundle\Entity\Interfaces;

interface IUser
{
    public function getType(): string;
    public function getFormTypeClass(): string;
}