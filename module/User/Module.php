<?php
namespace User;

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
use User\Model\Message;
use User\Model\MessageTable;
use Anime\Form\EditAnimeOnListFilter;
use Anime\Form\EditAnimeOnListForm;
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
                'MessageTable' =>  function($sm) {
                    $tableGateway = $sm->get('MessageTableGateway');
                    $table = new MessageTable($tableGateway);
                    return $table;
                },
                'MessageTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Message());
                    return new TableGateway('message', $dbAdapter, null, $resultSetPrototype);
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
                'EditAnimeOnListForm' => function ($sm) {
                    $form = new EditAnimeOnListForm();
                    $form->setInputFilter($sm->get('EditAnimeOnListFilter'));
                    return $form;
                },
                'EditAnimeOnListFilter' => function ($sm) {
                    return new EditAnimeOnListFilter();
                },
                'MessageForm' => function ($sm) {
                    $form = new Form\MessageForm($sm, 'New ticket');
                    $form->setInputFilter($sm->get('MessageFilter'));
                    return $form;
                },
                'MessageFilter' => function ($sm) {
                    return new Form\MessageFilter();
                },
                'ReplyForm' => function ($sm) {
                    $form = new Form\ReplyForm();
                    $form->setInputFilter($sm->get('ReplyFilter'));
                    return $form;
                },
                'ReplyFilter' => function ($sm) {
                    return new Form\ReplyFilter();
                },
            ),
        );
    }

}
