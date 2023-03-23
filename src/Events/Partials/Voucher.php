<?php

namespace belenka\ExponeaApi\Events\Partials;

/**
 * Representation of voucher (coupon) used in purchase
 * @package belenka\ExponeaApi\Events\Partials
 */
class Voucher
{
    /**
     * @var string
     */
    protected $code;
    /**
     * @var float
     */
    protected $value;
    /**
     * @var float
     */
    protected $percentage;

    public function __construct(string $code, float $value, float $percentage)
    {
        $this->setCode($code);
        $this->setValue($value);
        $this->setPercentage($percentage);
    }

    public function setCode(string $value): void
    {
        $this->code = $value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function setPercentage(float $value): void
    {
        $this->percentage = $value;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }
}
