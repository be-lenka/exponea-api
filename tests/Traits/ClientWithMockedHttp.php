<?php

namespace belenka\ExponeaApiTest\Traits;

use GuzzleHttp\Handler\MockHandler;
use belenka\ExponeaApi\Client;

trait ClientWithMockedHttp
{
    protected $publicKey = 'publickey';
    protected $privateKey = 'privatekey';
    protected $projectToken = 'project-token';

    /**
     * @var MockHandler|null
     */
    protected $mockHandler;

    /**
     * Get configured Client object with set up MockHandler
     * @param array|null $opts Additional options to be passed to Client
     * @return Client
     */
    protected function getClient(array $opts = null): Client
    {
        $this->mockHandler = new MockHandler();

        return new Client([
            'public_key' => $this->publicKey,
            'private_key' => $this->privateKey,
            'project_token' => $this->projectToken,
            'http_client' => [
                'handler' => $this->mockHandler
            ]
        ] + ($opts ?? []));
    }
}
