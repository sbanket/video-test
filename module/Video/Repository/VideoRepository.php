<?php

namespace Video\Repository;

use PDO;

/**
 * Class VideoRepository
 *
 * @package Video\Repository
 */
class VideoRepository
{
    /**
     * @var Pdo
     */
    private $conn;

    /**
     * CategoryRepository constructor.
     *
     * @param Pdo $conn
     */
    public function __construct(Pdo $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getVideo(int $id)
    {
        $query = 'SELECT id, title, shows, clicks, ctr FROM videos WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $video = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($video === false) {
            return null;
        }

        return $video;
    }

    /**
     * @param int      $start
     * @param int      $limit
     * @param int|null $category
     *
     * @return array
     */
    public function getVideos(int $start = null, int $limit = null, int $category = null)
    {
        $query = 'SELECT id, title, shows, clicks, ctr FROM videos';
        if ($category !== null) {
            $query .= ' INNER JOIN video_category ON videos.id = video_category.video_id WHERE video_category.category_id = :category';
        }

        $query .= ' ORDER BY ctr DESC';

        if ($start !== null && $limit !== null) {
            $query .= ' LIMIT :start, :limit';
        }

        $stmt = $this->conn->prepare($query);
        if ($start !== null && $limit !== null) {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        if ($category !== null) {
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int|null $category
     *
     * @return int
     */
    public function getVideosCount(int $category = null)
    {
        $query = 'SELECT count(1) FROM videos';
        if ($category !== null) {
            $query .= ' INNER JOIN video_category ON videos.id = video_category.video_id WHERE video_category.category_id = :category';
        }

        $stmt = $this->conn->prepare($query);
        if ($category !== null) {
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param int $video
     */
    public function updateClicks(int $video)
    {
        $query = 'UPDATE videos SET clicks = clicks+1, ctr = clicks/shows WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $video, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateShows(array $ids)
    {
        $idsStr = str_repeat('?,', count($ids) - 1) . '?';
        $query  = "UPDATE videos SET shows = shows+1, ctr = clicks/shows WHERE id in ($idsStr)";
        $stmt   = $this->conn->prepare($query);
        $stmt->execute($ids);
    }
}