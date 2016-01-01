<?php

namespace Anime;

return array(
    'controllers' => array(
        'invokables' => array(
            'Anime\Controller\Anime' => 'Anime\Controller\AnimeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'anime' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/anime',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'Anime\Controller\Anime',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
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
