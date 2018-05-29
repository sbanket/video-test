<?php

namespace Tag\Repository;

use PDO;

/**
 * Class TagRepository
 *
 * @package Tag\Repository
 */
class TagRepository
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
     * @param int|null $video
     *
     * @return array
     */
    public function getTags(int $video = null)
    {
        $query = 'SELECT id, name FROM tags';
        if ($video !== null) {
            $query .= ' INNER JOIN video_tag ON tag.id = video_tag.tag_id WHERE video_tag.video_id = :video';
        }

        $stmt = $this->conn->prepare($query);
        if ($video !== null) {
            $stmt->bindParam(':video', $video, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }
}