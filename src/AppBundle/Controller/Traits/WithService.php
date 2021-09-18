<?php

namespace AppBundle\Controller\Traits;

use AppBundle\Repository\AbstractRepository;
use AppBundle\Service\AbstractService;

trait WithService
{
    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * @param AbstractService $service
     * @param ...$attachments
     *
     * $attachment => [['setMethod' => value], ['setMethod' => value]]
     *
     */
    protected function attachToService(AbstractService $service, ...$attachments)
    {
        $this->service = $service;
        foreach ($attachments as $attachmentsByMethodAndValue) {
            foreach ($attachmentsByMethodAndValue as $method => $attachment) {
                if (is_string($method)) {
                    $service->$method($attachment);
                }
            }
        }
    }

    abstract public function initialize(): void;
}