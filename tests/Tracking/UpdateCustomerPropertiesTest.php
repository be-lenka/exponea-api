<?php

namespace belenka\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Events\Partials\RegisteredCustomer;
use belenka\ExponeaApi\Exception\UnsuccessfulResponseException;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

class UpdateCustomerPropertiesTest extends TestCase
{
    use ClientWithMockedHttp;

    public function testUpdateCustomerPropertiesRequest()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => true])
        ));

        $email = 'marian@exponea.com';
        $properties = [
            'first_name' => 'Marian',
            'fidelity_points' => 687,
        ];

        $client->tracking()->updateCustomerProperties(new RegisteredCustomer($email), $properties)->wait();

        $request = $this->mockHandler->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            $client->getEndpointUri() . '/track/v2/projects/' . $this->projectToken . '/customers',
            $request->getUri()
        );

        $body = json_decode($request->getBody()->getContents(), true);

        $this->assertArrayHasKey('customer_ids', $body);
        $this->assertSame(['registered' => $email], $body['customer_ids']);

        $this->assertArrayHasKey('properties', $body);

        $this->assertArrayHasKey('first_name', $body['properties']);
        $this->assertSame('Marian', $body['properties']['first_name']);

        $this->assertArrayHasKey('fidelity_points', $body['properties']);
        $this->assertSame(687, $body['properties']['fidelity_points']);
    }

    public function testUpdateCustomerPropertiesSuccessFalse()
    {
        $this->expectException(UnsuccessfulResponseException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => false])
        ));

        $email = 'marian@exponea.com';
        $properties = [
            'first_name' => 'Marian',
            'fidelity_points' => 687,
        ];

        $client->tracking()->updateCustomerProperties(new RegisteredCustomer($email), $properties)->wait();
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
