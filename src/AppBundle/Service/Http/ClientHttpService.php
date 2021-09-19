<?php

namespace AppBundle\Service\Http;

use AppBundle\Service\Interfaces\IClientHttp;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class ClientHttpService implements IClientHttp
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;


    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * @param ResponseInterface $response
     * @return stdClass
     */
    public function buildResponse(ResponseInterface $response): stdClass
    {
        $std = new stdClass();
        $std->statusCode = $response->getStatusCode();
        $std->data = json_decode($response->getBody());

        return $std;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return stdClass
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, array $options = []): stdClass
    {
        $response = $this->httpClient->request($method, $uri, $options);

        return $this->buildResponse($response);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @param callable|null $cb
     */
    public function requestAsync(string $method, string $uri, array $options = [], callable $cb = null): void
    {
        $promise = $this->httpClient->requestAsync($method, $uri, $options);
        $promise->then(
            function (ResponseInterface $response) use ($cb) {
                if (is_callable($cb)) {
                    $cb($this->buildResponse($response));
                }
            }
        );
    }
}