<?php

namespace belenka\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Events\Consent;
use belenka\ExponeaApi\Events\Partials\RegisteredCustomer;
use belenka\ExponeaApi\Exception\UnsuccessfulResponseException;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Test for GET /system/time method
 * @see https://docs.exponea.com/reference#add-event
 * @see https://docs.exponea.com/docs/consent-definition (missing information for consents/agreements export)
 * @package belenka\ExponeaApiTest\Tracking
 */
class AddEventTest extends TestCase
{
    use ClientWithMockedHttp;

    const EXAMPLE_EMAIL = 'example@example.com';

    /**
     * Test for successful request with new event to store
     */
    public function testAddEventRequest()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => true])
        ));

        $event = new Consent(
            new RegisteredCustomer(self::EXAMPLE_EMAIL),
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_GRANT
        );
        $client->tracking()->addEvent($event)->wait();

        // Request verification
        $request = $this->mockHandler->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            $client->getEndpointUri() . '/track/v2/projects/' . $this->projectToken . '/customers/events',
            $request->getUri()
        );
        $body = json_decode($request->getBody()->getContents(), true);

        $this->assertArrayHasKey('customer_ids', $body);
        $this->assertSame(['registered' => self::EXAMPLE_EMAIL], $body['customer_ids']);

        $this->assertArrayHasKey('event_type', $body);
        $this->assertSame('consent', $body['event_type']);

        $this->assertArrayHasKey('properties', $body);

        $this->assertArrayHasKey('action', $body['properties']);
        $this->assertSame('accept', $body['properties']['action']);

        $this->assertArrayHasKey('category', $body['properties']);
        $this->assertSame(Consent::CATEGORY_NEWSLETTER, $body['properties']['category']);

        $this->assertArrayHasKey('valid_until', $body['properties']);
        $this->assertSame('unlimited', $body['properties']['valid_until']);

        $this->assertEqualsWithDelta(
            time(),
            $body['properties']['timestamp'],
            2,
            'Default timestamp is not equal to current time'
        );
    }

    /**
     * Test {"success": false} response as Exponea returns this field so we have to handle it in case they would
     * return it with successful HTTP code
     */
    public function testAddEventSuccessFalse()
    {
        $this->expectException(UnsuccessfulResponseException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => false])
        ));

        $event = new Consent(
            new RegisteredCustomer(self::EXAMPLE_EMAIL),
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_GRANT
        );
        $client->tracking()->addEvent($event)->wait();
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
