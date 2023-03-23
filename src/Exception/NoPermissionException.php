<?php

namespace belenka\ExponeaApi\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Exception throwed when detected  "no permission" response from Expoena as it doesn't come with 4xx http status code
 *
 * From Exponea documentation:
 * The request is completed, but you receive no permission message in a response.
 *
 * No permission message means that you aren´t allowed to retrieve requested data. You have to set this permissions to
 * data in Exponea APP (Settings-> API settings -> Get/set permissions).
 */
class NoPermissionException extends BadResponseException
{
}
