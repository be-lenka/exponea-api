<?php

namespace belenka\ExponeaApi\Catalog\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getCatalogName() call
 * @package belenka\ExponeaApi\Response
 */
class CatalogName
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string 
     */
    protected $name;
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_DATA = 'data';

    /**
     * CatalogName constructor.
     * @param array $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if(isset($data[self::FIELD_DATA])) {
            if (isset($data[self::FIELD_DATA][self::FIELD_ID])) {
                $this->setId($data[self::FIELD_DATA][self::FIELD_ID]);
            } else {
                throw new MissingResponseFieldException(self::FIELD_ID);
            }

            if (isset($data[self::FIELD_DATA][self::FIELD_NAME])) {
                $this->setName($data[self::FIELD_DATA][self::FIELD_NAME]);
            } else {
                throw new MissingResponseFieldException(self::FIELD_NAME);
            }
        }
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): int
    {
        return $this->name;
    }
}
