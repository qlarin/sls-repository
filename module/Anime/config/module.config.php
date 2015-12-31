<?php

namespace Anime;

return array(
    'controllers' => array(
        'invokables' => array(
        ),
    ),
    'router' => array(
        'routes' => array(
        ),
    ),
    'service_manager' => require __DIR__ . '/service.config.php',
    'view_manager' => array(
        'template_path_stack' => array(
            'anime' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/anime_layout'           => __DIR__ . '/../view/layout/anime_layout.phtml',
            'active' =>true,
        ),
    ),
);
