<?php

namespace belenka\ExponeaApi\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Exception thrown where received success: false response
 *
 * Behavior of this field is not documentated in Exponea.
 *
 * @package belenka\ExponeaApiTest\Exception
 */
class UnsuccessfulResponseException extends BadResponseException
{
}
