<?php

namespace AppBundle\Exceptions\Http;

use AppBundle\Exceptions\AbstractException;

class AbstractHttpException extends AbstractException
{
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const BAD_REQUEST = 'BAD_REQUEST';
    const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';

    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}