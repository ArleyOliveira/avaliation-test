<?php

namespace AppBundle\Service\Log;

use Exception;
use Monolog\Logger;

class LogService
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Exception $e
     */
    public function register(Exception $e) {
        $this->logger->addError($e->getMessage(), $e->getTrace());
    }

}