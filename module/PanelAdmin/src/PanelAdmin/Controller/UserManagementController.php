<?php

/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class UserManagementController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/admin_layout');
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $viewModel  = new ViewModel(array(
            'admin' => $user,
            'users' => $userTable->fetchAll()
        ));
        return $viewModel;
    }

    public function deleteAction()
    {
        $this->layout('layout/admin_layout');
        $this->getServiceLocator()->get('UserTable')
            ->deleteUser($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute('admin/manage-users');
    }

    public function editAction()
    {
        $this->layout('layout/admin_layout');
        $admin = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($admin)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $admin);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('UsersEditForm');
        $form->bind($user);
        $viewModel = new ViewModel(array(
            'form' => $form,
            'id' => $this->params()->fromRoute('id')
        ));
        return $viewModel;
    }

    public function processAction()
    {
        $this->layout('layout/admin_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('admin/manage-users', array('action' => 'edit'));
        }

        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($post->id);
        $form = $this->getServiceLocator()->get('UsersEditForm');
        $form->bind($user);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, please enter correct data',
                'form' => $form,
            ));
            $model->setTemplate('panel-admin/user-management/edit');
            return $model;
        }

        $this->getServiceLocator()->get('UserTable')->saveUser($user);
        return $this->redirect()->toRoute('admin/manage-users');
    }
}