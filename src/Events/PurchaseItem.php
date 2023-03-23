<?php

namespace belenka\ExponeaApi\Events;

use JsonSerializable;
use belenka\ExponeaApi\Events\Traits\CustomerIdTrait;
use belenka\ExponeaApi\Events\Traits\DiscountTrait;
use belenka\ExponeaApi\Events\Traits\ItemIdentificationTrait;
use belenka\ExponeaApi\Events\Traits\PurchaseIdentificationTrait;
use belenka\ExponeaApi\Events\Traits\QuantityTrait;
use belenka\ExponeaApi\Events\Traits\SourceTrait;
use belenka\ExponeaApi\Events\Traits\TimestampTrait;
use belenka\ExponeaApi\Interfaces\CustomerIdInterface;
use belenka\ExponeaApi\Interfaces\EventInterface;
use belenka\ExponeaApi\Events\Traits\PriceTrait;
use belenka\ExponeaApi\Events\Partials\Category;
use belenka\ExponeaApi\Events\Traits\StatusTrait;

/**
 * Event of one item purchase (equal to one order row)
 * @package belenka\ExponeaApi\Events
 * @phpstan-type PurchaseItemJson array{
 *  status: string,
 *  purchase_id: string,
 *  item_id: string,
 *  item_price: float,
 *  item_sku: string,
 *  item_name: string,
 *  category_id: string,
 *  category_name: string,
 *  quantity: int,
 *  total_price: float,
 *  source: string,
 *  discount_value?: float,
 *  discount_percentage?: float
 * }
 */
class PurchaseItem implements EventInterface
{
    use CustomerIdTrait;
    use PurchaseIdentificationTrait;
    use TimestampTrait;
    use ItemIdentificationTrait;
    use PriceTrait;
    use QuantityTrait;
    use StatusTrait;
    use SourceTrait;
    use DiscountTrait;

    /**
     * @var string
     */
    protected $sku;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Category
     */
    protected $category;

    public function __construct(
        CustomerIdInterface $customerIds,
        string $purchaseID,
        string $id,
        float $price,
        int $quantity,
        string $sku,
        string $name,
        Category $category
    ) {
        $this->setCustomerIds($customerIds);
        $this->setPurchaseID($purchaseID);
        $this->setItemID($id);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setSKU($sku);
        $this->setName($name);
        $this->setCategory($category);
        $this->setTimestamp(microtime(true));
    }

    public function setSKU(string $sku): void
    {
        $this->sku = $sku;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getSKU(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->price;
    }

    public function getEventType(): string
    {
        return 'purchase_item';
    }

    /**
     * Get event properties
     * @return PurchaseItemJson
     */
    public function getProperties()
    {
        /** @var PurchaseItemJson */
        $data = array_filter(
            [
                'status' => $this->getStatus(),
                'purchase_id' => $this->getPurchaseID(),
                'item_id' => $this->getItemID(),
                'item_price' => $this->getPrice(),
                'item_sku' => $this->getSKU(),
                'item_name' => $this->getName(),
                'category_id' => $this->category->getID(),
                'category_name' => $this->getCategory()->getName(),
                'quantity' => $this->getQuantity(),
                'total_price' => $this->getTotalPrice(),
                'source' => $this->getSource(),
                'discount_value' => $this->getDiscountValue(),
                'discount_percentage' => $this->getDiscountPercentage(),
            ],
            function ($value) {
                return $value !== null;
            }
        );
        return $data;
    }
}
