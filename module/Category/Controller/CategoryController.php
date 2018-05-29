<?php

namespace Category\Controller;

use App\Controller\Controller;
use App\Db\Db;
use App\View\View;
use Category\Model\CategoryModel;
use Video\Model\VideoModel;

/**
 * Class CategoryController
 *
 * @package Category\Controller
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryModel
     */
    private $categoryModel;

    /**
     * @var VideoModel
     */
    private $videoModel;

    /**
     * CategoryController constructor
     */
    public function __construct()
    {
        $this->categoryModel = new CategoryModel(Db::getInstance()->getConnection());
        $this->videoModel    = new VideoModel(Db::getInstance()->getConnection());
    }

    /**
     * return void
     */
    public function listAction()
    {
        $page       = $this->getQuery('page', 1);
        $categories = $this->categoryModel->getCategories($page);
        $countPages = ceil($this->categoryModel->getCategoriesCount() / CategoryModel::PER_PAGE);
        $view       = new View(
            'module/Category/View/list.phtml',
            ['categories' => $categories, 'page' => $page, 'countPages' => $countPages]
        );

        $view->setTitle('Categories');
        $view->render();
    }

    /**
     * return void
     */
    public function categoryAction()
    {
        $categoryId = $this->getRoute('category_id');
        $page       = $this->getQuery('page', 1);
        $category   = $this->categoryModel->getCategory($categoryId);
        if (empty($category)) {
            throw new \InvalidArgumentException('Category is not found', 404);
        }

        $videos = $this->videoModel->getVideos($page, $category->getId());
        $this->videoModel->updateShows($videos);
        $countPages = ceil($this->videoModel->getVideosCount($category->getId()) / VideoModel::PER_PAGE);
        $view       = new View(
            'module/Category/View/category.phtml',
            ['videos' => $videos, 'category' => $category, 'page' => $page, 'countPages' => $countPages]
        );

        $view->setTitle(sprintf('%s category', $category->getName()));
        $view->render();
    }
}