<?php

namespace belenka\ExponeaApi\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Exception thrown when response doesn't match to expected schema
 * @package belenka\ExponeaApiTest\Exception
 */
class UnexpectedResponseSchemaException extends BadResponseException
{
}
