<?php

namespace AppBundle\Exceptions\Factories;

use AppBundle\Exceptions\AbstractException;

abstract class ExceptionFactory
{
    /**
     * @param string $className
     * @param string $message
     * @param array $details
     * @return AbstractException
     */
    public static function create(string $className, string $message, array $details = array()): AbstractException {
        return new $className($message, $details);
    }
}