<?php

namespace Tag\Model;

use App\Hydrator\ClassMethodHydrator;
use PDO;
use Tag\Dto\TagTo;
use Tag\Repository\TagRepository;

/**
 * Class TagModel
 *
 * @package Tag\Model
 */
class TagModel
{
    /**
     * @var TagRepository
     */
    private $repository;

    /**
     * @var ClassMethodHydrator
     */
    private $hydrator;

    /**
     * VideoModel constructor.
     *
     * @param PDO $conn
     */
    public function __construct(Pdo $conn)
    {
        $this->repository = new TagRepository($conn);
        $this->hydrator   = new ClassMethodHydrator();
    }

    /**
     * @param int|null $video
     *
     * @return TagTo[]
     */
    public function getVideos(int $video = null)
    {
        $tags   = $this->repository->getTags($video);
        $result = [];
        foreach ($tags as $tag) {
            $dto      = $this->hydrator->hydrate($tag, new TagTo());
            $result[] = $dto;
        }

        return $result;
    }
}