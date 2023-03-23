<?php

namespace belenka\ExponeaApi\Catalog\Partials;

use JsonSerializable;
use belenka\ExponeaApi\Interfaces\CatalogItemInterface;

/**
 * Representation of catalog item object
 * @package belenka\ExponeaApi\Catalog\Partials
 */
class CatalogItem implements CatalogItemInterface, JsonSerializable
{
    /**
     * @var integer|null
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $catalogId;

    /**
     * @var array 
     */
    protected $properties = [];
    
    public function __construct(string $id, string $catalogId = null, $properties = [])
    {
        $this->setID($id);
        $this->setCatalogID($catalogId);
        $this->setProperties($properties);
    }

    public function setID(int $id): void
    {
        $this->id = $id;
    }

    public function setCatalogID(string $catalogId): void
    {
        $this->catalogId = $catalogId;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getCatalogID(): string
    {
        return $this->catalogId;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }
    
    public function jsonSerialize()
    {
        return [
            'properties' => $this->getProperties()
        ];
    }
}
