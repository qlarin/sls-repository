<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class UserController extends AbstractActionController
{

    protected $authService;

    public function indexAction()
    {
        $this->layout('layout/user_layout');
        $user = $this->getLoggedUser();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $viewModel  = new ViewModel(array('user' => $user));
        return $viewModel;
    }
    public function editAction()
    {
        $this->layout('layout/user_layout');
        $user = $this->getLoggedUser();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $viewModel  = new ViewModel(array('form' => $form, 'id' => $this->params()->fromRoute('id')));
        return $viewModel;
    }
    public function processAction()
    {
        $this->layout('layout/user_layout');

        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('user', array('action' => 'edit'));
        }
        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($post->id);

        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, try one more time!',
                'form'  => $form,
            ));
            $model->setTemplate('user/edit');
            return $model;
        }
        // Save user
        $this->getServiceLocator()->get('UserTable')->saveUser($user);
        return $this->redirect()->toRoute('user');
    }

    private function getLoggedUser()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        return $user;
    }
}