<?php

namespace Video\Dto;

use Category\Dto\CategoryTo;
use Tag\Dto\TagTo;

/**
 * Class VideoTo
 *
 * @package Video\Dto
 */
class VideoTo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $shows;

    /**
     * @var int
     */
    private $clicks;

    /**
     * @var double
     */
    private $ctr;

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var array
     */
    private $categories = [];

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
     * @return VideoTo
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return VideoTo
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getShows(): int
    {
        return $this->shows;
    }

    /**
     * @param int $shows
     *
     * @return VideoTo
     */
    public function setShows(int $shows)
    {
        $this->shows = $shows;
        return $this;
    }

    /**
     * @return int
     */
    public function getClicks(): int
    {
        return $this->clicks;
    }

    /**
     * @param int $clicks
     *
     * @return VideoTo
     */
    public function setClicks(int $clicks)
    {
        $this->clicks = $clicks;
        return $this;
    }

    /**
     * @return float
     */
    public function getCtr(): float
    {
        return $this->ctr;
    }

    /**
     * @param float $ctr
     *
     * @return VideoTo
     */
    public function setCtr(float $ctr)
    {
        $this->ctr = $ctr;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param int|null $limit
     *
     * @return string
     */
    public function getTagsStr(int $limit = null): string
    {
        $tagsName = [];
        /** @var TagTo $tag */
        foreach ($this->tags as $tag) {
            if (!empty($limit) && count($tagsName) == $limit) {
                break;
            }
            $tagsName[] = $tag->getName();
        }

        return implode(', ', $tagsName);
    }

    /**
     * @param array $tags
     *
     * @return VideoTo
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getCategoriesStr(): string
    {
        $categoriesName = [];
        /** @var CategoryTo $category */
        foreach ($this->categories as $category) {
            $categoriesName[] = $category->getName();
        }

        return implode(', ', $categoriesName);
    }

    /**
     * @param array $categories
     *
     * @return VideoTo
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;

        return $this;
    }
}