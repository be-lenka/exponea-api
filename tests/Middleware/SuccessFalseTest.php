<?php

namespace belenka\ExponeaApiTest;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Exception\UnsuccessfulResponseException;
use belenka\ExponeaApiTest\Traits\ClientWithMockedHttp;

class SuccessFalseTest extends TestCase
{
    use ClientWithMockedHttp;

    const SUCCCESS_FIELD = 'success';

    /**
     * Check if success: false inside JSON sent in 200 OK response will be recognized as error
     * @dataProvider providerSuccessFalseBodies
     * @param string $body Body to be used in request
     */
    public function testSuccessFalseInJson(string $body)
    {
        $this->expectException(UnsuccessfulResponseException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            $body
        ));
        $client->call(new Request('POST', '/test'))->wait();
    }

    /**
     * 400+ http codes handler should be called before "success false" verificaiton
     * @dataProvider providerSuccessFalseBodies
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

    public function providerSuccessFalseBodies()
    {
        return [
            [json_encode([self::SUCCCESS_FIELD => false])],
            [json_encode([self::SUCCCESS_FIELD => false, 'error' => 'some error'])],
            [json_encode([self::SUCCCESS_FIELD => false, 'errors' => ['error1', 'error2']])],
        ];
    }

    protected function tearDown(): void
    {
        $this->mockHandler = null;
    }
}
