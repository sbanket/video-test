<?php

namespace Video\Controller;

use App\Controller\Controller;
use App\Db\Db;
use App\View\View;
use Category\Model\CategoryModel;
use Video\Model\VideoModel;

/**
 * Class CategoryController
 *
 * @package App\Controller
 */
class VideoController extends Controller
{
    /**
     * @var VideoModel
     */
    private $videoModel;

    /**
     * @var CategoryModel
     */
    private $categoryModel;

    /**
     * CategoryController constructor
     */
    public function __construct()
    {
        $this->videoModel    = new VideoModel(Db::getInstance()->getConnection());
        $this->categoryModel = new CategoryModel(Db::getInstance()->getConnection());
    }

    /**
     * return void
     */
    public function videoAction()
    {
        $videoId    = $this->getRoute('video_id');
        $categoryId = $this->getRoute('category_id');
        $video      = $this->videoModel->getVideo($videoId);
        if (empty($video)) {
            throw new \InvalidArgumentException('Video is not found', 404);
        }

        $category = $this->categoryModel->getCategory($categoryId);
        if (empty($category)) {
            throw new \InvalidArgumentException('Category is not found', 404);
        }

        $view = new View(
            'module/Video/View/video.phtml',
            ['video' => $video, 'category' => $category]
        );

        $view->setTitle('Video');
        $view->render();
    }

    /**
     * return void
     */
    public function videoClickAction()
    {
        $videoId    = $this->getRoute('video_id');
        $categoryId = $this->getRoute('category_id');
        $video      = $this->videoModel->getVideo($videoId);
        if (empty($video)) {
            throw new \InvalidArgumentException('Video is not found', 404);
        }

        $category = $this->categoryModel->getCategory($categoryId);
        if (empty($category)) {
            throw new \InvalidArgumentException('Category is not found', 404);
        }

        $this->videoModel->updateClicks($video);
        header(sprintf("Location: /category/%s/video/%s", $category->getId(), $videoId));
    }
}