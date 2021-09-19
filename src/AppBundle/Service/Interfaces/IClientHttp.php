<?php

namespace AppBundle\Service\Interfaces;

use Psr\Http\Message\ResponseInterface;
use stdClass;

interface IClientHttp
{
    /**
     * @param ResponseInterface $response
     * @return stdClass
     */
    public function buildResponse(ResponseInterface $response): stdClass;

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return stdClass
     */
    public function request(string $method, string $uri, array $options = []): stdClass;

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @param callable|null $cb
     */
    public function requestAsync(string $method, string $uri, array $options = [], callable $cb = null): void;
}