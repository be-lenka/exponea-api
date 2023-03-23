<?php

namespace belenka\ExponeaApiTest;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Test case checking if default Guzzle middleware is still there
 * @package belenka\ExponeaApiTest
 */
class RejectsBaseHttpErrorsTest extends TestCase
{
    use ClientWithMockedHttp;

    /**
     * Checks if 400+ http codes verification is on top level so all http errors will be handled
     * in Guzzle-standard way
     * @dataProvider providerHttpFailureCodes
     * @param int $httpCode Checked http code in response
     * @param string $expectedException Expected exception (it changes between 400 and 500 http codes)
     */
    public function testHttpFailureCodes(int $httpCode, string $expectedException)
    {
        $this->expectException($expectedException);

        $client = $this->getClient();

        $this->mockHandler->append(new Response(
            $httpCode,
            ['content-type' => 'application/json'],
            'anything'
        ));

        $client->call(new Request('POST', '/test'))->wait();
    }

    public function providerHttpFailureCodes()
    {
        return [
            [400, ClientException::class],
            [401, ClientException::class],
            [500, ServerException::class],
            [501, ServerException::class]
        ];
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
