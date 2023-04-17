<?php

namespace belenka\ExponeaApi\Catalog\Partials;

use JsonSerializable;
use belenka\ExponeaApi\Interfaces\CreateCatalogInterface;

/**
 * Representation of create catalog object
 * @package belenka\ExponeaApi\Catalog\Partials
 */
class CreateCatalog implements CreateCatalogInterface, JsonSerializable
{
    /**
     * @var string|null
     */
    protected $name;
    
    /**
     * @var boolean|null
     */
    protected $isProductCatalog;

    /**
     * @var array 
     */
    protected $fields = [];
    
    public function __construct(string $name, $isProductCatalog = false, $fields = [])
    {
        $this->setName($name);
        $this->setIsProductCatalog($isProductCatalog);
        $this->setFields($fields);
    }

    public function setName(string $value): void
    {
        $this->name = $value;
    }

    public function setIsProductCatalog($value): void
    {
        $this->isProductCatalog = $value;
    }

    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isProductCatalog(): bool
    {
        return $this->isProductCatalog;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
    
    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'is_product_catalog' => $this->isProductCatalog(),
            'fields' => $this->getFields()
        ];
    }
}
