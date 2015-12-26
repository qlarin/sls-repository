<?php

namespace User;

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Login' => 'User\Controller\LoginController',
            'User\Controller\Register' => 'User\Controller\RegisterController',
            'User\Controller\User' => 'User\Controller\UserController',
            'PanelAdmin\Controller\Admin' => 'PanelAdmin\Controller\AdminController',
            'PanelAdmin\Controller\UserManagement' => 'PanelAdmin\Controller\UserManagementController',
            'PanelAdmin\Controller\AnimeManagement' => 'PanelAdmin\Controller\AnimeManagementController',
            'PanelAdmin\Controller\Messages' => 'PanelAdmin\Controller\MessagesController',
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
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'PanelAdmin\Controller\Admin',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'manage-users' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/manage-users[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'PanelAdmin\Controller\UserManagement',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'manage-animelist' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/manage-animelist[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'PanelAdmin\Controller\AnimeManagement',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'messages' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/messages[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'PanelAdmin\Controller\Messages',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
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
