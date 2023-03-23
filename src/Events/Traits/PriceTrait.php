<?php

namespace belenka\ExponeaApi\Events\Traits;

trait PriceTrait
{
    /**
     * @var float
     */
    protected $price;

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
