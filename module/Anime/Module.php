<?php
namespace Anime;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use User\Model\User;
use User\Model\UserTable;
use User\Model\ListRow;
use User\Model\ListRowTable;
use Anime\Model\Anime;
use Anime\Model\AnimeTable;
use Anime\Model\Comment;
use Anime\Model\CommentTable;
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
                'AnimeTable' =>  function($sm) {
                    $tableGateway = $sm->get('AnimeTableGateway');
                    $table = new AnimeTable($tableGateway);
                    return $table;
                },
                'AnimeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Anime());
                    return new TableGateway('anime', $dbAdapter, null, $resultSetPrototype);
                },
                'ListRowTable' =>  function($sm) {
                    $tableGateway = $sm->get('ListRowTableGateway');
                    $table = new ListRowTable($tableGateway);
                    return $table;
                },
                'ListRowTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ListRow());
                    return new TableGateway('list_row', $dbAdapter, null, $resultSetPrototype);
                },
                'CommentTable' =>  function($sm) {
                    $tableGateway = $sm->get('CommentTableGateway');
                    $table = new CommentTable($tableGateway);
                    return $table;
                },
                'CommentTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Comment());
                    return new TableGateway('comment', $dbAdapter, null, $resultSetPrototype);
                },
                'AddAnimeToListForm' => function ($sm) {
                    $form = new Form\AddAnimeToListForm();
                    $form->setInputFilter($sm->get('AddAnimeToListFilter'));
                    return $form;
                },
                'AddAnimeToListFilter' => function ($sm) {
                    return new Form\AddAnimeToListFilter();
                },
                'AddCommentForm' => function ($sm) {
                    $form = new Form\AddCommentForm();
                    $form->setInputFilter($sm->get('AddCommentFilter'));
                    return $form;
                },
                'AddCommentFilter' => function ($sm) {
                    return new Form\AddCommentFilter();
                },
            ),
        );
    }

}
