<?php

namespace Tag\Dto;

/**
 * Class TagTo
 *
 * @package Tag\Dto
 */
class TagTo
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
     * @return TagTo
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
     * @return TagTo
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}