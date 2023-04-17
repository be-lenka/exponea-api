<?php

namespace belenka\ExponeaApi\Catalog\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of createCatalog() call
 * @package belenka\ExponeaApi\Response
 */
class CreateCatalog
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var boolean
     */
    protected $success;
    
    const FIELD_ID = 'id';
    const FIELD_SUCCESS = 'success';

    /**
     * CreateCatalog constructor.
     * @param array $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if (isset($data[self::FIELD_ID])) {
            $this->setId($data[self::FIELD_ID]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_ID);
        }

        if (isset($data[self::FIELD_SUCCESS])) {
            $this->setSuccess($data[self::FIELD_SUCCESS]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_SUCCESS);
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
