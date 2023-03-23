<?php


namespace belenka\ExponeaApi\Events\Partials;

use JsonSerializable;
use belenka\ExponeaApi\Events\Traits\ItemIdentificationTrait;
use belenka\ExponeaApi\Events\Traits\QuantityTrait;
use belenka\ExponeaApi\Events\Traits\PriceTrait;

/**
 * Entity class for single item of purchase items array
 * @package belenka\ExponeaApi\Events\Partials
 * @phpstan-type ItemJson array{item_id: string, price: float, quantity: int}
 */
class Item implements JsonSerializable
{
    use ItemIdentificationTrait;
    use PriceTrait;
    use QuantityTrait;

    public function __construct(string $id, float $price, int $quantity)
    {
        $this->setItemID($id);
        $this->setPrice($price);
        $this->setQuantity($quantity);
    }

    /**
     * @return ItemJson|mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'item_id' => $this->getItemID(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity()
        ];
    }
}
