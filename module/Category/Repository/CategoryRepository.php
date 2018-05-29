<?php

namespace Category\Repository;

use PDO;

/**
 * Class CategoryRepository
 *
 * @package Category\Repository
 */
class CategoryRepository
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
    public function getCategory(int $id)
    {
        $query = 'SELECT id, name FROM categories WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($category === false) {
            return null;
        }

        return $category;
    }

    /**
     * @param int|null $start
     * @param int|null $limit
     * @param int|null $video
     *
     * @return array
     */
    public function getCategories(int $start = null, int $limit = null, int $video = null)
    {
        $query = 'SELECT id, name FROM categories';
        if ($video !== null) {
            $query .= ' INNER JOIN video_category ON categories.id = video_category.category_id WHERE video_category.video_id = :video';
        }

        if ($start !== null && $limit !== null) {
            $query .= ' LIMIT :start, :limit';
        }

        $stmt = $this->conn->prepare($query);
        if ($start !== null && $limit !== null) {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        if ($video !== null) {
            $stmt->bindParam(':video', $video, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getCategoriesCount()
    {
        $query = 'SELECT count(1) FROM categories';
        $count = $this->conn->query($query)->fetchColumn();

        return $count;
    }
}