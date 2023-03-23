<?php

namespace belenka\ExponeaApi\Events\Traits;

trait QuantityTrait
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
