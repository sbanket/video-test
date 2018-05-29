<?php

namespace Category\Model;

use App\Hydrator\ClassMethodHydrator;
use Category\Dto\CategoryTo;
use Category\Repository\CategoryRepository;
use PDO;

/**
 * Class CategoryModel
 *
 * @package Category\Model
 */
class CategoryModel
{
    const PER_PAGE = 10;

    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * @var ClassMethodHydrator
     */
    private $hydrator;

    /**
     * CategoryRepository constructor.
     *
     * @param Pdo $conn
     */
    public function __construct(Pdo $conn)
    {
        $this->repository = new CategoryRepository($conn);
        $this->hydrator   = new ClassMethodHydrator();
    }

    /**
     * @param int $id
     *
     * @return CategoryTo|null
     */
    public function getCategory(int $id)
    {
        $category = $this->repository->getCategory($id);
        if (empty($category)) {
            return null;
        }
        return $this->hydrator->hydrate($category, new CategoryTo());
    }

    /**
     * @param int      $page
     * @param int|null $video
     *
     * @return CategoryTo[]
     */
    public function getCategories(int $page = null, int $video = null)
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
        $categories = $this->repository->getCategories($start, $limit, $video);
        $result     = [];
        foreach ($categories as $category) {
            $dto      = $this->hydrator->hydrate($category, new CategoryTo());
            $result[] = $dto;
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getCategoriesCount()
    {
        return $this->repository->getCategoriesCount();
    }
}