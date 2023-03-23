<?php

namespace belenka\ExponeaApi\Tracking\Response;

use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getSystemTime() call
 * @package belenka\ExponeaApi\Response
 */
class SystemTime
{
    /**
     * @var float
     */
    protected $time;

    const FIELD_TIME = 'time';

    /**
     * SystemTime constructor.
     * @param array{time?: float} $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if (isset($data[self::FIELD_TIME])) {
            $this->setTime($data[self::FIELD_TIME]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_TIME);
        }
    }

    /**
     * @param float $time
     */
    public function setTime(float $time): void
    {
        $this->time = $time;
    }

    /**
     * @return float
     */
    public function getTime(): float
    {
        return $this->time;
    }
}
