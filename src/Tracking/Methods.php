<?php

namespace belenka\ExponeaApi\Tracking;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;
use belenka\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use belenka\ExponeaApi\Interfaces\CustomerIdInterface;
use belenka\ExponeaApi\Interfaces\EventInterface;
use belenka\ExponeaApi\Tracking\Response\SystemTime;
use belenka\ExponeaApi\Traits\ApiContainerTrait;

/**
 * Methods contained inside Tracking API
 * @package belenka\ExponeaApi\Tracking
 */
class Methods
{
    use ApiContainerTrait;

    protected function getMethodUri(string $method): string
    {
        return '/track/v2/projects/' . $this->getClient()->getProjectToken() . $method;
    }

    /**
     * Get system time
     *
     * Promise resolves to Response\SystemTime object
     * @return PromiseInterface
     */
    public function getSystemTime(): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/track/v2/projects/{projectToken}/system/time'
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new SystemTime(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Propagate event to Expponea
     *
     * Please note that sending event for customer id which doesn't exist in Exponea, will automatically create
     * contact with sent identifier. It's transparent from your side (there will be no errors).
     *
     * Promise resolves to null
     * @param EventInterface $event
     * @return PromiseInterface
     */
    public function addEvent(EventInterface $event): PromiseInterface
    {
        $customerIds = [];
        if ($event->getCustomerIDs()->getRegistered() !== null) {
            $customerIds[$event->getCustomerIDs()->getRegisteredKey()] = $event->getCustomerIDs()->getRegistered();
        }
        if ($event->getCustomerIDs()->getCookie() !== null) {
            $customerIds['cookie'] = $event->getCustomerIDs()->getCookie();
        }

        $body = [
            'customer_ids' => $customerIds,
            'event_type' => $event->getEventType(),
            'timestamp' => $event->getTimestamp(),
            'properties' => $event->getProperties(),
        ];
        $request = new Request(
            'POST',
            '/track/v2/projects/{projectToken}/customers/events',
            [],
            json_encode($body) ?: '{}'
        );
        
        return $this->getClient()->call($request)->then(function ($e) {
            return $e->getStatusCode() == 200;
        });
    }

    /**
     * @param CustomerIdInterface $customerID
     * @param array<string,mixed> $properties
     * @return PromiseInterface
     */
    public function updateCustomerProperties(CustomerIdInterface $customerID, array $properties)
    {
        $customerIds = [];
        if ($customerID->getRegistered() !== null) {
            $customerIds[$customerID->getRegisteredKey()] = $customerID->getRegistered();
        }
        if ($customerID->getCookie() !== null) {
            $customerIds['cookie'] = $customerID->getCookie();
        }
        $customerIds = $customerIds + ($customerID->getSoftIDs() ?? []);

        // Lets override empty array with stdclass so json_encode will create {} instead of []
        // Exponea will reject requests with JSON arrays
        if ($properties === []) {
            $properties = new stdClass();
        }

        $body = [
            'customer_ids' => $customerIds,
            'properties' => $properties,
        ];

        $request = new Request(
            'POST',
            '/track/v2/projects/{projectToken}/customers',
            [],
            json_encode($body) ?: '{}'
        );

        return $this->getClient()->call($request)->then(function ($e) {
            return $e->getStatusCode() == 200;
        });
    }
}
