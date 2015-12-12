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
        $this->layout('layout/layout');
        $this->layout()->setVariable('userActive', 'active');
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $viewModel  = new ViewModel(array('user' => $user));
        return $viewModel;
    }
    public function editAction()
    {
        $this->layout('layout/layout');

        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        var_dump($user);
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $viewModel  = new ViewModel(array('form' => $form, 'id' => $user->id));
        return $viewModel;
    }

    public function processAction()
    {
        $this->layout('layout/layout');

        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('user', array('action' => 'edit'));
        }
        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($post->id);
        var_dump($user);
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, check your data!',
                'form'  => $form,
            ));
            $model->setTemplate('user/edit');
            return $model;
        }

        // Save user
        $this->getServiceLocator()->get('UserTable')->saveUser($user);

        return $this->redirect()->toRoute('user');
    }
}