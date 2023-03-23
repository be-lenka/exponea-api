<?php

namespace belenka\ExponeaApi\Events\Traits;

trait StatusTrait
{
    /**
     * @var string
     */
    protected $status = 'success';

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
