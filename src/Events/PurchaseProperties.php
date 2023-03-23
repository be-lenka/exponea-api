<?php

namespace belenka\ExponeaApi\Events;

use belenka\ExponeaApi\Events\Traits\CustomerIdTrait;
use belenka\ExponeaApi\Events\Traits\TimestampTrait;
use belenka\ExponeaApi\Interfaces\CustomerIdInterface;
use belenka\ExponeaApi\Interfaces\EventInterface;

/**
 * Purchase event
 * @package belenka\ExponeaApi\Events
 */
class PurchaseProperties implements EventInterface
{
    use CustomerIdTrait;
    use TimestampTrait;

    /**
     * @var array
     */
    protected $data = [];

    public function __construct(
        CustomerIdInterface $customerIds,
        array $data
    ) {
        $this->setCustomerIds($customerIds);
        $this->setPurchaseData($data);
        $this->setTimestamp(microtime(true));
    }

    /**
     * @param array $data
     */
    public function setPurchaseData(array $data): void
    {
        $this->data = $data;
    }

    public function getEventType(): string
    {
        return 'purchase';
    }

    /**
     * @return PurchaseJson
     */
    public function getProperties()
    {
        /** @var PurchaseJson */
        $data = array_filter(
            $this->data,
            function ($value) {
                return $value !== null;
            }
        );
        return $data;
    }
}
