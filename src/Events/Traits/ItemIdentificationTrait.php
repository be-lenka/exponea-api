<?php

namespace belenka\ExponeaApi\Events\Traits;

trait ItemIdentificationTrait
{
    /**
     * @var string
     */
    protected $itemID;

    /**
     * @return string
     */
    public function getItemID(): string
    {
        return $this->itemID;
    }

    /**
     * @param string $itemID
     */
    public function setItemID(string $itemID): void
    {
        $this->itemID = $itemID;
    }
}
