<?php
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use User\Model\User;
use User\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;

class Module implements AutoloaderProviderInterface
{
	public function onBootstrap($e)
	{
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
        $sharedEventManager = $eventManager->getSharedManager(); // The shared event manager
        $sharedEventManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) {
            $controller = $e->getTarget(); // The controller which is dispatched
            $controllerName = $controller->getEvent()->getRouteMatch()->getParam('controller');
            if (!in_array($controllerName,array(
                'User\Controller\Register',
                'User\Controller\Login',
                'User\Controller\User',
            ))) {
                $controller->layout('layout/layout');
            }
        });
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
		);
	}

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthService' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user','email','password','MD5(?)');

                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                'UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                'RegisterForm' => function ($sm) {
                    $form = new Form\RegisterForm();
                    $form->setInputFilter($sm->get('RegisterFilter'));
                    return $form;
                },
                'RegisterFilter' => function ($sm) {
                    return new Form\RegisterFilter();
                },
                'LoginForm' => function ($sm) {
                    $form = new Form\LoginForm();
                    $form->setInputFilter($sm->get('LoginFilter'));
                    return $form;
                },
                'LoginFilter' => function ($sm) {
                    return new Form\LoginFilter();
                },
                'UserEditForm' => function ($sm) {
                    $form = new Form\UserEditForm();
                    $form->setInputFilter($sm->get('UserEditFilter'));
                    return $form;
                },
                'UserEditFilter' => function ($sm) {
                    return new Form\UserEditFilter();
                },
            ),
        );
    }

}
