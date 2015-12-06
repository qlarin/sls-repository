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
                    'route' => '/register',
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
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
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
