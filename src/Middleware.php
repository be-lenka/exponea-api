<?php

namespace belenka\ExponeaApi;

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;
use belenka\ExponeaApi\Exception\NoPermissionException;
use belenka\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use belenka\ExponeaApi\Exception\UnsuccessfulResponseException;

class Middleware
{
    /**
     * Verification of "no permission" phrase inside body
     * @return \Closure
     */
    public static function verifyPermissions()
    {
        return function (callable $handler) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options)->then(function (ResponseInterface $response) use ($request) {
                    $body = $response->getBody()->getContents();

                    // Detection of "no permission response"
                    if (mb_stripos($body, 'no permission') !== false) {
                        throw new NoPermissionException(
                            'You don\'t have permission to use this method',
                            $request,
                            $response
                        );
                    }
                    return $response->withBody(Utils::streamFor($body));
                });
            };
        };
    }

    /**
     * Validation of received JSON message
     * @return \Closure
     */
    public static function validateJson()
    {
        return function (callable $handler) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options)->then(function (ResponseInterface $response) use ($request) {
                    $body = $response->getBody()->getContents();

                    // Validation of JSON
                    json_decode($body, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new UnexpectedResponseSchemaException(
                            'Response does not seem to be valid JSON: ' . json_last_error_msg(),
                            $request,
                            $response
                        );
                    }
                    return $response->withBody(Utils::streamFor($body));
                });
            };
        };
    }

    /**
     * Validation of received JSON message
     * @return \Closure
     */
    public static function checkSuccessFlag()
    {
        return function (callable $handler) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options)->then(function (ResponseInterface $response) use ($request) {
                    $body = $response->getBody()->getContents();

                    // Verification of success flag
                    $json = json_decode($body, true);
                    if (isset($json['success']) && $json['success'] === false) {
                        $message = 'Received unexpected success: false response';
                        if (isset($json['errors'])) {
                            $message .= ', errors: ' . json_encode($json['errors']);
                        } elseif (isset($json['error'])) {
                            $message .= ', error: ' . json_encode($json['error']);
                        }
                        throw new UnsuccessfulResponseException(
                            $message,
                            $request,
                            $response
                        );
                    }
                    return $response->withBody(Utils::streamFor($body));
                });
            };
        };
    }
}
