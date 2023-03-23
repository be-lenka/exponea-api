<?php

namespace belenka\ExponeaApi\Catalog\Partials;

use belenka\ExponeaApi\Interfaces\CatalogInterface;

/**
 * Representation of catalog object
 * @package belenka\ExponeaApi\Catalog\Partials
 */
class Catalog implements CatalogInterface
{
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var integer|null
     */
    protected $itemId;

    /**
     * @var array 
     */
    protected $queryParameters = [];
    
    public function __construct(string $id, string $itemId = null, $queryParameters = [])
    {
        $this->setID($id);
        $this->setItemID($itemId);
        $this->setQueryParameters($queryParameters);
    }

    public function setID(string $id): void
    {
        $this->id = $id;
    }

    public function setItemID($itemId): void
    {
        $this->itemId = $itemId;
    }

    public function setQueryParameters(array $queryParameters): void
    {
        $this->queryParameters = $queryParameters;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function getItemID(): int
    {
        return $this->itemId;
    }

    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }
}
