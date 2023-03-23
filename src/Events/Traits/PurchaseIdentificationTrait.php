<?php

namespace belenka\ExponeaApi\Events\Traits;

trait PurchaseIdentificationTrait
{
    /**
     * @var string
     */
    protected $purchaseID;

    /**
     * @return string
     */
    public function getPurchaseID(): string
    {
        return $this->purchaseID;
    }

    /**
     * @param string $purchaseID
     */
    public function setPurchaseID(string $purchaseID): void
    {
        $this->purchaseID = $purchaseID;
    }
}
