<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;

abstract class Middleware
{
    /**
     * @var Middleware
     */
    protected $next;

    /**
     * @param Middleware $next
     * @return Middleware
     */
    public function linkWith(Middleware $next): Middleware
    {
        $this->next = $next;

        return $next;
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    protected function checkNext(): bool
    {
        if (null === $this->next) {
            return true;
        }

        return $this->next->check();
    }

    /**
     * @return bool
     * @throws AbstractException
     */
    public abstract function check(): bool;
}