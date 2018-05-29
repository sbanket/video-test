<?php

namespace Video\Hydrator;

use App\Db\Db;
use App\Hydrator\ClassMethodHydrator;
use Category\Model\CategoryModel;
use Tag\Model\TagModel;
use Video\Dto\VideoTo;

/**
 * Class VideoHydrator
 *
 * @package Video\Hydrator
 */
class VideoHydrator
{
    /**
     * @var CategoryModel
     */
    private $categoryModel;

    /**
     * @var TagModel
     */
    private $tagModel;

    /**
     * VideoHydrator constructor.
     */
    public function __construct()
    {
        $this->categoryModel = new CategoryModel(Db::getInstance()->getConnection());
        $this->tagModel      = new TagModel(Db::getInstance()->getConnection());
    }

    /**
     * @param array $data
     * @param       $object
     *
     * @return VideoTo
     */
    public function hydrate(array $data, $object)
    {
        $hydrator = new ClassMethodHydrator();
        /** @var VideoTo $video */
        $video = $hydrator->hydrate($data, $object);

        $categories = $this->categoryModel->getCategories(null, $video->getId());
        $video->setCategories($categories);

        $tags = $this->categoryModel->getCategories(null, $video->getId());
        $video->setTags($tags);

        return $video;
    }
}