<?php

namespace App\Config;

use Category\Controller\CategoryController;
use Video\Controller\VideoController;

return [
    '/'                                              => [
        'controller' => CategoryController::class,
        'action'     => 'list',
    ],
    '/category/{category_id}'                        => [
        'controller' => CategoryController::class,
        'action'     => 'category',
    ],
    '/category/{category_id}/video/{video_id}'       => [
        'controller' => VideoController::class,
        'action'     => 'video',
    ],
    '/category/{category_id}/video-click/{video_id}' => [
        'controller' => VideoController::class,
        'action'     => 'videoClick',
    ],
];