<?php

namespace belenka\ExponeaApiTest;

use \ReflectionObject;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Tracking\Methods;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

class ClientTest extends TestCase
{
    use ClientWithMockedHttp;

    /**
     * @throws \ReflectionException
     */
    public function testSetsCredentials()
    {
        $client = $this->getClient();

        // getPrivateKey is private due to security reasons so we need to use reflection
        $reflection = new ReflectionObject($client);
        $method = $reflection->getMethod('getPrivateKey');
        $method->setAccessible(true);

        $this->assertSame($this->projectToken, $client->getProjectToken());
        $this->assertSame($this->publicKey, $client->getPublicKey());
        $this->assertSame($this->privateKey, $method->invoke($client));
    }

    public function testDefaultEndpointUri()
    {
        $client = $this->getClient();
        $this->assertSame('https://api.exponea.com', $client->getEndpointUri());
    }

    public function testOverrideEndpointUri()
    {
        $uri = 'https://some-endpoint.example.com';
        $client = $this->getClient([
            'endpoint_uri' => $uri,
        ]);
        $this->assertSame($uri, $client->getEndpointUri());
    }

    public function testReturnsTrackingApi()
    {
        $this->assertInstanceOf(
            Methods::class,
            $this->getClient()->tracking()
        );
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
