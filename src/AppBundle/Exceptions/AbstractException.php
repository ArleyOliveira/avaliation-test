<?php

namespace AppBundle\Exceptions;

use AppBundle\Exceptions\Interfaces\IException;
use Exception;

class AbstractException extends Exception
{
    /**
     * @var array
     */
    protected $details;

    /**
     * @param string $message
     * @param array $details
     */
    public function __construct(string $message, array $details = array())
    {
        parent::__construct($message);
        $this->details = $details;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}