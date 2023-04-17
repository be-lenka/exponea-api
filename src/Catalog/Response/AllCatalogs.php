<?php

namespace belenka\ExponeaApi\Catalog\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getAllCatalogs() call
 * @package belenka\ExponeaApi\Response
 */
class AllCatalogs
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var boolean
     */
    protected $success;
    
    const FIELD_DATA = 'data';
    const FIELD_SUCCESS = 'success';

    /**
     * AllCatalog constructor.
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

        if (isset($data[self::FIELD_SUCCESS])) {
            $this->setSuccess($data[self::FIELD_SUCCESS]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_SUCCESS);
        }
    }

    /**
     * @param array $value
     */
    public function setData(array $value): void
    {
        $this->data = $value;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param boolean $value
     */
    public function setSuccess(string $value): void
    {
        $this->success = $value;
    }

    /**
     * @return boolean
     */
    public function getSuccess(): int
    {
        return $this->success;
    }
}
