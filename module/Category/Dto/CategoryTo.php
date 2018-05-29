<?php

namespace Category\Dto;

/**
 * Class CategoryTo
 *
 * @package Category\Dto
 */
class CategoryTo
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return CategoryTo
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return CategoryTo
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}