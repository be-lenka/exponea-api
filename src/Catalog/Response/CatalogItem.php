<?php

namespace belenka\ExponeaApi\Catalog\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getCatalogItem() call
 * @package belenka\ExponeaApi\Response
 */
class CatalogItem
{
    use \belenka\ExponeaApi\Events\Traits\StatusTrait;
    
    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var integer 
     */
    protected $itemId;
    
    const FIELD_DATA = 'data';
    const FIELD_PROPERTIES = 'properties';
    const FIELD_ITEM_ID = 'item_id';

    /**
     * CatalogName constructor.
     * @param array $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if (isset($data[self::FIELD_DATA])) {
            if (isset($data[self::FIELD_DATA][self::FIELD_PROPERTIES])) {
                $this->setProperties($data[self::FIELD_DATA][self::FIELD_PROPERTIES]);
            } else {
                throw new MissingResponseFieldException(self::FIELD_PROPERTIES);
            }

            if (isset($data[self::FIELD_DATA][self::FIELD_ITEM_ID])) {
                $this->setItemId($data[self::FIELD_DATA][self::FIELD_ITEM_ID]);
            } else {
                throw new MissingResponseFieldException(self::FIELD_ITEM_ID);
            }
        }
    }

    /**
     * @param array $data
     */
    public function setProperties(array $data): void
    {
        $this->properties = $data;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param integer $value
     */
    public function setItemId(int $value): void
    {
        $this->itemId = $value;
    }

    /**
     * @return integer
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }
}
