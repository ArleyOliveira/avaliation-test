<?php

namespace AppBundle\Middleware;

use AppBundle\Exceptions\AbstractException;

abstract class Validator
{
    /**
     * @var Validator
     */
    protected $next;

    /**
     * @param Validator $next
     * @return Validator
     */
    public function linkWith(Validator $next): Validator
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