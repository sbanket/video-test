<?php

namespace Video\Model;

use PDO;
use Video\Dto\VideoTo;
use Video\Hydrator\VideoHydrator;
use Video\Repository\VideoRepository;

/**
 * Class VideoModel
 *
 * @package Video\Model
 */
class VideoModel
{
    const PER_PAGE = 10;

    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * @var VideoHydrator
     */
    private $hydrator;

    /**
     * VideoModel constructor.
     *
     * @param PDO $conn
     */
    public function __construct(Pdo $conn)
    {
        $this->repository = new VideoRepository($conn);
        $this->hydrator   = new VideoHydrator();
    }

    /**
     * @param int $id
     *
     * @return VideoTo
     */
    public function getVideo(int $id)
    {
        $video = $this->repository->getVideo($id);
        if (empty($video)) {
            return null;
        }

        return $this->hydrator->hydrate($video, new VideoTo());
    }

    /**
     * @param int      $page
     * @param int|null $category
     *
     * @return VideoTo[]
     */
    public function getVideos(int $page = null, int $category = null)
    {
        if ($page !== null && $page <= 0) {
            $page = 1;
        }

        $start = null;
        $limit = null;
        if ($page !== null) {
            $start = ($page - 1) * self::PER_PAGE;
            $limit = self::PER_PAGE;
        }

        $videos = $this->repository->getVideos($start, $limit, $category);
        $result = [];
        foreach ($videos as $video) {
            $dto      = $this->hydrator->hydrate($video, new VideoTo());
            $result[] = $dto;
        }

        return $result;
    }

    /**
     * @param int|null $category
     *
     * @return int
     */
    public function getVideosCount(int $category = null)
    {
        return $this->repository->getVideosCount($category);
    }

    /**
     * @param VideoTo[] $videos
     */
    public function updateShows(array $videos)
    {
        if (empty($videos)) {
            return;
        }

        $ids = [];
        foreach ($videos as $video) {
            $ids[] = $video->getId();
        }
        $this->repository->updateShows($ids);
    }

    /**
     * @param VideoTo $video
     */
    public function updateClicks(VideoTo $video)
    {
        $this->repository->updateClicks($video->getId());
    }
}