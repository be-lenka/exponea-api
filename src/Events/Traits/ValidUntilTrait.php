<?php

namespace belenka\ExponeaApi\Events\Traits;

trait ValidUntilTrait
{
    /**
     * @var float|null
     */
    protected $validUntil;

    /**
     * @param float|null $validUntil
     */
    public function setValidUntil(?float $validUntil): void
    {
        $this->validUntil = $validUntil;
    }

    /**
     * @return float|null
     */
    public function getValidUntil(): ?float
    {
        return $this->validUntil;
    }
}
