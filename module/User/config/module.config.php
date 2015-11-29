<?php

namespace User;

return array(
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
		),
	),		
	'controllers' => array(
		'invokables' => array(
			'User\Controller\Login' => Controller\LoginController::class		
		),		
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'user' => __DIR__ . '/../view',
		),
	),
);
