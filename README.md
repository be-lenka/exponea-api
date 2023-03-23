# Exponea API SDK for PHP

Library contains only basic functionality which is needed for Exponea integration. If you miss some method, please post merge request as our integration just does not need them. 

Entire library uses asynchronous Guzzle requests. Please keep in mind that every Promise returned by methods must be called with wait() to be executed.

Public and private key authorization is used in Exponea API so you will need to get 3 values to make valid requests:

- public key
- private key
- project token

Exponea API reference: https://documentation.bloomreach.com/engagement/reference/welcome

## Usage example
 
Please check following source implementing API intialization and getSystemTime() method:

Usage:
```php
use belenka\ExponeaApi\Client;

$client = new Client([
    'public_key' => getenv('EXPONEA_PUBLIC_KEY'),
    'private_key' => getenv('EXPONEA_PRIVATE_KEY'),
    'project_token' => getenv('EXPONEA_PROJECT_TOKEN'),
]);
try {
    $systemTime = $client->tracking()->getSystemTime()->wait(); // returns SystemTime object
} catch (...) { ... }
```

## Tracking API

All methods are contained inside `$client->tracking()` method.

### Set contact agreements (consents)

Both e-mail and SMS agreements are called *consents* in Exponea. They can be granted or revoked.

```php
$event = new Consent(
    new RegisteredCustomer('example@example.com'),
    Consent::CATEGORY_NEWSLETTER,
    Consent::ACTION_GRANT
);
try {
    $client->tracking()->addEvent($event)->wait(); // does not return anything
} catch (...) { ... }
```

### Send purchase

Exponea needs you to send at least two events: Purchase and PurchaseItem (one for every purchase item).

```php
$purchase = new Purchase(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    [
        new Item('012345', 2.99, 1),
    ], // purchase items
    'COD' // payment method
);
$purchaseItem = new PurchaseItem(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    '012345', // item id
    2.99, // price
    2, // quantity
    'SKU012345', // sku (stock keeping unit)
    'Product name',
    new Category('CAT1', 'Some > Category > Breadcrumb')
);
```

You can optionally send voucher used during purchase. Please refer to `$voucher` argument of `Purchase` constructor.


### Update customer properties

```php
try {
    $properties = [
        'fidelity_points' => 657,
        'first_name' => 'Marian',
    ];

    $client->tracking()->updateCustomerProperties(
        new RegisteredCustomer('marian@exponea.com'), $properties
    )->wait();
} catch (...) { ... }
```

With this method you can update customer properties. Required field in properties is 'first_name'.



## Catalog API

All methods are contained inside `$client->catalog()` method.

### Get catalog name

```php
try {
    $catalog = new Catalog('<exponea_catalog_id>');

    $response = $this->client
        ->catalog()
        ->getCatalogName($catalog)
        ->wait()
    ;
} catch (...) { ... }
```

### Get catalog items

```php
try {
    $catalog = new Catalog('<exponea_catalog_id>');
    $catalog->setQueryParameters([
        'query' => 1,
        'field' => 'item_id',
        'count' => 1
    ]);

    $response = $this->client
        ->catalog()
        ->getCatalogItems($catalog)
        ->wait()
    ;
} catch (...) { ... }
```

### Get catalog item by ID

```php
try {
    $catalog = new Catalog('<exponea_catalog_id>');
    $catalog->setItemID(1);

    $response = $this->client
        ->catalog()
        ->getCatalogItem($catalog)
        ->wait()
    ;
} catch (...) { ... }
```

### Create catalog item

```php
try {
    $catalogItem = new CatalogItem(1, '<exponea_catalog_id>');
    $catalogItem->setProperties([
        'code' => 'product_code',
        'active' => false,
        'title' => 'product title'
        // etc ...
    ]);

    $response = $this->client
        ->catalog()
        ->createCatalogItem($catalogItem)
        ->wait()
    ;
} catch (...) { ... }
```

### Update catalog item

```php
try {
    $catalogItem = new CatalogItem(1, '<exponea_catalog_id>');
    $catalogItem->setProperties([
        'title' => 'new product title'
        // etc ...
    ]);

    $response = $this->client
        ->catalog()
        ->updateCatalogItem($catalogItem)
        ->wait()
    ;
} catch (...) { ... }
```