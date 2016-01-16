<?php

namespace User;

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Login' => 'User\Controller\LoginController',
            'User\Controller\Register' => 'User\Controller\RegisterController',
            'User\Controller\User' => 'User\Controller\UserController',
            'User\Controller\List' => 'User\Controller\ListController',
            'User\Controller\Support' => 'User\Controller\SupportController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/login[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action' => 'login',
                    ),
                ),
                'may_terminate' => true,
            ),
            'logout' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action' => 'logout',
                    ),
                ),
                'may_terminate' => true,
            ),
            'register' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/register[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Register',
                        'action' => 'register',
                    ),
                ),
                'may_terminate' => true,
            ),
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
            'list' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/list[/:action[/:id]]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\List',
                        'action' => 'anime',
                    ),
                ),
                'may_terminate' => true,
            ),
            'support' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/support[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Support',
                        'action' => 'mailbox',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'service_manager' => require __DIR__ . '/service.config.php',
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/user_layout'           => __DIR__ . '/../view/layout/user_layout.phtml',
            'active' =>true,
        ),
    ),
);
