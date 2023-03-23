<?php

namespace belenka\ExponeaApi\Exception\Internal;

use \Exception;

/**
 * Exception thrown by Response/* classes when data lacks required fields
 * @package belenka\ExponeaApi\Exception\Internal
 */
class MissingResponseFieldException extends Exception
{
    /**
     * @var string
     */
    protected $field;

    public function __construct(string $field)
    {
        parent::__construct("Field '${field}' is missing in received response");
        $this->setField($field);
    }

    /**
     * @param string $field
     */
    protected function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
