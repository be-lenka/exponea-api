<?php

namespace belenka\ExponeaApi\Events\Traits;

trait CategoryAndActionTrait
{
    /**
     * @var string
     */
    protected $category;
    /**
     * @var string
     */
    protected $action;

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
