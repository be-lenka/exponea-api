<?php

namespace belenka\ExponeaApi\Catalog\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getCatalogItems() call
 * @package belenka\ExponeaApi\Response
 */
class CatalogItems
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var integer 
     */
    protected $matched;
    
    const FIELD_DATA = 'data';
    const FIELD_MATCHED = 'matched';

    /**
     * CatalogName constructor.
     * @param array $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if (isset($data[self::FIELD_DATA])) {
            $this->setData($data[self::FIELD_DATA]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_DATA);
        }
        
        if (isset($data[self::FIELD_MATCHED])) {
            $this->setMatched($data[self::FIELD_MATCHED]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_MATCHED);
        }
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param integer $value
     */
    public function setMatched(int $value): void
    {
        $this->matched = $value;
    }

    /**
     * @return integer
     */
    public function getMatched(): int
    {
        return $this->matched;
    }
}
