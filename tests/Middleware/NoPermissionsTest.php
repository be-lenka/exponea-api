<?php

namespace belenka\ExponeaApiTest;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Exception\NoPermissionException;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Validation if "no permission" responses are detected properly
 * @see https://docs.exponea.com/reference#response-types
 * @package belenka\ExponeaApiTest
 */
class NoPermissionsTest extends TestCase
{
    const NO_PERMISSION_STRING = 'no permission';

    use ClientWithMockedHttp;

    /**
     * Check for valid detection of 'no permission' message (it will be returned along with 200 http code according
     * to documentation)
     * Middleware order is crucial as we expect that this response can be plain string (not JSON one)
     * @dataProvider providerNoPermissionsBodies
     * @param string $body Body to be used in request
     */
    public function testNoPermissionsWithin200Response(string $body)
    {
        $this->expectException(NoPermissionException::class);

        $client = $this->getClient();

        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            $body
        ));
        $client->call(new Request('POST', '/test'))->wait();
    }
    /**
     * 400+ http codes handler should be called before "no permission"
     * @dataProvider providerNoPermissionsBodies
     * @param string $body Body to be used in request
     */
    public function testNoPermissionsWith400HttpCode(string $body)
    {
        $this->expectException(ClientException::class);

        $client = $this->getClient();

        $this->mockHandler->append(new Response(
            400,
            ['content-type' => 'application/json'],
            $body
        ));
        $client->call(new Request('POST', '/test'))->wait();
    }

    public function providerNoPermissionsBodies()
    {
        return [
            [self::NO_PERMISSION_STRING],
            [mb_convert_case(self::NO_PERMISSION_STRING, MB_CASE_TITLE)],
            [json_encode(['success' => false, 'error' => self::NO_PERMISSION_STRING])],
            [json_encode(['success' => false, 'errors' => [self::NO_PERMISSION_STRING]])],
        ];
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
