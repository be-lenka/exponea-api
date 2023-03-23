<?php

namespace belenka\ExponeaApi\Events\Partials;

/**
 * Representation of item category
 * @package belenka\ExponeaApi\Events\Partials
 */
class Category
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    public function __construct(string $id, string $name)
    {
        $this->setID($id);
        $this->setName($name);
    }

    public function setID(string $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
