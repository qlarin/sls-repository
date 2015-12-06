<?php

namespace User;

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Login' => 'User\Controller\LoginController',
            'User\Controller\Register' => 'User\Controller\RegisterController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action' => 'login',
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
        ),
    ),
    'service_manager' => require __DIR__ . '/service.config.php',
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.twig',
            'user/register/register' => __DIR__ . '/../view/user/register/register.twig',
            'error/404'               => __DIR__ . '/../view/error/404.twig',
            'error/index'             => __DIR__ . '/../view/error/index.twig',
            'active' => true,
        ),
        'strategies' => array('ZfcTwigViewStrategy')
    ),
    'zfctwig' => array(
        'environment_loader' => 'ZfcTwigLoaderChain',
        'environment_class' => 'Twig_Environment',
        'environment_options' => array(),
        'loader_chain' => array(
            'ZfcTwigLoaderTemplateMap',
            'ZfcTwigLoaderTemplatePathStack'
        ),
        'extensions' => array(
            'zfctwig' => 'ZfcTwigExtension'
        ),
        'suffix' => 'twig',
        'enable_fallback_functions' => true,
        'disable_zf_model' => true,
        'helper_manager' => array(
            'configs' => array(
                'Zend\Navigation\View\HelperConfig'
            )
        )
    )

);
