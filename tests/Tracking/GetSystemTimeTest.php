<?php

namespace belenka\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use belenka\ExponeaApi\Tracking\Response\SystemTime;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Test for GET /system/time method
 * @see https://docs.exponea.com/reference#system-time
 * @package belenka\ExponeaApiTest\Tracking
 */
class GetSystemTimeTest extends TestCase
{
    use ClientWithMockedHttp;

    public function testValidResponse()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            '{"success": true, "time": 123456.78}' // copied from api documentation
        ));
        /** @var SystemTime $response */
        $response = $client->tracking()->getSystemTime()->wait(true);
        $this->assertInstanceOf(SystemTime::class, $response);
        $this->assertSame(123456.78, $response->getTime());

        // Request verification
        $request = $this->mockHandler->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            $client->getEndpointUri() . '/track/v2/projects/' . $this->projectToken . '/system/time',
            $request->getUri()
        );
        $body = json_decode($request->getBody()->getContents(), true);
        $this->assertEmpty($body);
    }

    public function testIncompleteResponse()
    {
        $this->expectException(UnexpectedResponseSchemaException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            '{"success": true}' // copied from api documentation
        ));
        $client->tracking()->getSystemTime()->wait(true);
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
