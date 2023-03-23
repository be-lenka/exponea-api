<?php

namespace belenka\ExponeaApi\Events\Traits;

trait TimestampTrait
{
    /**
     * @var float
     */
    protected $timestamp;

    /**
     * @param float $timestamp
     */
    public function setTimestamp(float $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return float
     */
    public function getTimestamp(): float
    {
        return $this->timestamp;
    }
}
