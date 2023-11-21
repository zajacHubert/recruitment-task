<?php

declare(strict_types=1);

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class PetClient
{
    protected Client $client;
    protected string $baseUri;

    public function __construct(string $baseUri = 'https://petstore.swagger.io/v2/')
    {
        $this->client = new Client();
        $this->baseUri = rtrim($baseUri, '/') . '/';
    }

    public function sendRequest($method = 'GET', $path, $options = []): ResponseInterface
    {
        $url = $this->baseUri . ltrim($path, '/');

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            } else {
                throw $e;
            }
        }

        return $response;
    }
}
