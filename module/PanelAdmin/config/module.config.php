<?php

namespace PanelAdmin;

return array(
    'controllers' => array(
        'invokables' => array(
            'PanelAdmin\Controller\Admin' => 'PanelAdmin\Controller\AdminController',
            'PanelAdmin\Controller\UserManagement' => 'PanelAdmin\Controller\UserManagementController',
            'PanelAdmin\Controller\AnimeManagement' => 'PanelAdmin\Controller\AnimeManagementController',
            'PanelAdmin\Controller\Messages' => 'PanelAdmin\Controller\MessagesController',
        ),
    ),
    'router' => array(
        'routes' => array(
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
                        'may_terminate' => true,
                    ),
                    'manage-anime' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/manage-anime[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'PanelAdmin\Controller\AnimeManagement',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
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
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => require __DIR__ . '/service.config.php',
    'view_manager' => array(
        'template_path_stack' => array(
            'panel-admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/admin_layout'           => __DIR__ . '/../view/layout/admin_layout.phtml',
            'active' =>true,
        ),
    ),
);
