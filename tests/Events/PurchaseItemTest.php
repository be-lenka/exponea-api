<?php

namespace belenka\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use belenka\ExponeaApi\Events\PurchaseItem;
use belenka\ExponeaApi\Events\Partials\Category;
use belenka\ExponeaApi\Events\Partials\RegisteredCustomer;

class PurchaseItemTest extends TestCase
{
    public function testMinimalDataRequired()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new PurchaseItem(
            $customerID,
            'PREFIX12345',
            '012345',
            2.99,
            2,
            'SKU012345',
            'Product name',
            new Category('CAT1', 'Some > Category > Breadcrumb')
        );

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('purchase_item', $obj->getEventType());
        $this->assertEqualsWithDelta(microtime(true), $obj->getTimestamp(), 1, 'Timestamp is not generated properly');

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'status' => 'success',
                'purchase_id' => 'PREFIX12345',
                'item_id' => '012345',
                'item_price' => 2.99,
                'item_sku' => 'SKU012345',
                'item_name' => 'Product name',
                'category_id' => 'CAT1',
                'category_name' => 'Some > Category > Breadcrumb',
                'quantity' => 2,
                'total_price' => 5.98
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }

    public function testDataWithSource()
    {
        $obj = $this->getExampleObj();
        $obj->setSource('VPI');

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertArrayHasKey('source', $properties);
        $this->assertSame('VPI', $properties['source']);
    }

    public function testDataWithDiscount()
    {
        $obj = $this->getExampleObj();
        $obj->setDiscountValue(14.99);
        $obj->setDiscountPercentage(13.21);

        $properties = json_decode(json_encode($obj->getProperties()), true);

        $this->assertArrayHasKey('discount_value', $properties);
        $this->assertSame(14.99, $properties['discount_value']);

        $this->assertArrayHasKey('discount_percentage', $properties);
        $this->assertSame(13.21, $properties['discount_percentage']);
    }

    protected function getExampleObj(): PurchaseItem
    {
        return new PurchaseItem(
            new RegisteredCustomer('example@example.com'),
            'PREFIX12345',
            '012345',
            2.99,
            2,
            'SKU012345',
            'Product name',
            new Category('CAT1', 'Some > Category > Breadcrumb')
        );
    }
}
