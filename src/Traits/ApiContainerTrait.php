<?php

namespace belenka\ExponeaApi\Traits;

use belenka\ExponeaApi\Client;

trait ApiContainerTrait
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }
}
