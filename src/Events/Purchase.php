<?php

namespace belenka\ExponeaApi\Events;

use InvalidArgumentException;
use JsonSerializable;
use belenka\ExponeaApi\Events\Traits\CustomerIdTrait;
use belenka\ExponeaApi\Events\Traits\PurchaseIdentificationTrait;
use belenka\ExponeaApi\Events\Traits\SourceTrait;
use belenka\ExponeaApi\Events\Traits\TimestampTrait;
use belenka\ExponeaApi\Interfaces\CustomerIdInterface;
use belenka\ExponeaApi\Interfaces\EventInterface;
use belenka\ExponeaApi\Events\Partials\Item;
use belenka\ExponeaApi\Events\Partials\Voucher;
use belenka\ExponeaApi\Events\Traits\StatusTrait;

/**
 * Purchase event
 * @package belenka\ExponeaApi\Events
 * @phpstan-import-type ItemJson from Item
 * @phpstan-type PurchaseJson array{
 *   status: string,
 *   items: ItemJson[],
 *   purchase_id: string,
 *   total_price: float,
 *   total_quantity: int,
 *   payment_method: string,
 *   source: string,
 *   voucher_code?: string,
 *   voucher_percentage?: float,
 *   voucher_value?: float
 * }
 */
class Purchase implements EventInterface
{
    use CustomerIdTrait;
    use TimestampTrait;
    use PurchaseIdentificationTrait;
    use StatusTrait;
    use SourceTrait;

    /**
     * @var Item[]
     */
    protected $items = [];
    /**
     * @var string
     */
    protected $paymentMethod;
    /**
     * @var Voucher|null
     */
    protected $voucher = null;

    /** @param Item[] $items */
    public function __construct(
        CustomerIdInterface $customerIds,
        string $purchaseID,
        array $items,
        string $paymentMethod,
        Voucher $voucher = null
    ) {
        $this->setCustomerIds($customerIds);
        $this->setPurchaseID($purchaseID);
        $this->setItems($items);
        $this->setPaymentMethod($paymentMethod);
        $this->setVoucher($voucher);
        $this->setTimestamp(microtime(true));
    }

    /**
     * @param Item[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = [];

        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new InvalidArgumentException(
                    'Items of $items array must be instance of ' . Item::class
                );
            }
            $this->addItem($item);
        }
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param Voucher|null $voucher
     */
    public function setVoucher(?Voucher $voucher = null): void
    {
        $this->voucher = $voucher;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return Voucher|null
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    public function getEventType(): string
    {
        return 'purchase';
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            /** @var Item $item */
            $total = $total + $item->getPrice() * $item->getQuantity();
        }
        return $total;
    }

    /**
     * @return int
     */
    public function getTotalQuantity(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            /** @var Item $item */
            $total = $total + $item->getQuantity();
        }
        return $total;
    }

    /**
     * @return PurchaseJson
     */
    public function getProperties()
    {
        /** @var PurchaseJson */
        $data = array_filter(
            [
                'status' => $this->getStatus(),
                'items' => $this->getItems(),
                'purchase_id' => $this->getPurchaseID(),
                'total_price' => $this->getTotalPrice(),
                'total_quantity' => $this->getTotalQuantity(),
                'payment_method' => $this->getPaymentMethod(),
                'source' => $this->getSource(),
                'voucher_code' => $this->voucher === null ? null : $this->voucher->getCode(),
                'voucher_percentage' => $this->voucher === null ? null : $this->voucher->getPercentage(),
                'voucher_value' => $this->voucher === null ? null : $this->voucher->getValue(),
            ],
            function ($value) {
                return $value !== null;
            }
        );
        return $data;
    }
}
