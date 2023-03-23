<?php

namespace belenka\ExponeaApi\Events\Traits;

trait SourceTrait
{
    /**
     * @var string|null
     */
    protected $source = null;

    /**
     * @return string|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     */
    public function setSource(?string $source = null): void
    {
        $this->source = $source;
    }
}
