<?php

namespace belenka\ExponeaApi\Events\Traits;

use belenka\ExponeaApi\Interfaces\CustomerIdInterface;

trait CustomerIdTrait
{
    /**
     * @var CustomerIdInterface
     */
    protected $customerIds;

    /**
     * @param CustomerIdInterface $customerIds
     */
    public function setCustomerIds(CustomerIdInterface $customerIds): void
    {
        $this->customerIds = $customerIds;
    }

    /**
     * @return CustomerIdInterface
     */
    public function getCustomerIds(): CustomerIdInterface
    {
        return $this->customerIds;
    }
}
