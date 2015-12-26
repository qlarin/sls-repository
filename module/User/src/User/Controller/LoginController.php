<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


class LoginController extends AbstractActionController
{
	protected $storage;
	protected $authservice;

	public function loginAction()
	{
		$this->layout('layout/layout');
		$form = $this->getServiceLocator()->get('LoginForm');
		$user = $this->getAuthService()->getStorage()->read();
		if (!empty($user)) {
			return $this->redirect()->toRoute('user');
		}
		return new ViewModel(array(
				'form' => $form,
		));
	}

	public function getAuthService()
	{
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator()->get('AuthService');
		}

		return $this->authservice;
	}

	public function logoutAction()
	{
		$this->getAuthService()->clearIdentity();
		return $this->redirect()->toRoute('login');
	}

	public function processAction()
	{
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute('login');
		}
		$post = $this->request->getPost();
		$form = $this->getServiceLocator()->get('LoginForm');
		$form->setData($post);
		if (!$form->isValid()) {
			$model = new ViewModel(array(
					'error' => 'Something goes wrong, please repeat later',
					'form'  => $form,
			));
			$model->setTemplate('user/login/login');
			return $model;
		} else {
			//check authentication...
			$this->getAuthService()->getAdapter()
					->setIdentity($this->request->getPost('email'))
					->setCredential($this->request->getPost('password'));
			$result = $this->getAuthService()->authenticate();
			if ($result->isValid()) {
				$userTable = $this->getServiceLocator()->get('UserTable');
				$user = $userTable->getUserByEmail($this->request->getPost('email'));
				$this->getAuthService()->getStorage()->write($user);
				return $this->redirect()->toRoute('login', array(
						'action' =>  'confirm'
				));
			} else {
				$model = new ViewModel(array(
						'error' => 'Invalid credentials, try one more time',
						'form'  => $form,
				));
				$model->setTemplate('user/login/login');
				return $model;
			}
		}
	}
	public function confirmAction()
	{
		$this->layout('layout/layout');
		$this->layout()->setVariable('userActive', 'active');
		$user = $this->getAuthService()->getStorage()->read();
		$viewModel  = new ViewModel(array(
			'user' => $user
		));
		return $viewModel;
	}

}