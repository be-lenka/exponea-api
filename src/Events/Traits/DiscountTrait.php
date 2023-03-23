<?php

namespace belenka\ExponeaApi\Events\Traits;

trait DiscountTrait
{
    /**
     * @var float|null
     */
    protected $discountValue = null;
    /**
     * @var float|null
     */
    protected $discountPercentage = null;

    /**
     * @param float|null $discountPercentage
     */
    public function setDiscountPercentage(?float $discountPercentage = null): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @param float|null $discountValue
     */
    public function setDiscountValue(?float $discountValue = null): void
    {
        $this->discountValue = $discountValue;
    }

    /**
     * @return float|null
     */
    public function getDiscountPercentage(): ?float
    {
        return $this->discountPercentage;
    }

    /**
     * @return float|null
     */
    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }
}
