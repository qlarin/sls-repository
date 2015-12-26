<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use User\Model\User;

class RegisterController extends AbstractActionController
{
    public function registerAction()
    {
        $this->layout('layout/layout');
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (!empty($user)) {
            return $this->redirect()->toRoute('user');
        }
        $form = $this->getServiceLocator()->get('RegisterForm');
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function processAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('register');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'There were one or more isues with your submission. Please correct them as
    indicated below.',
                'form'  => $form,
            ));
            $model->setTemplate('user/register/register');
            return $model;
        }

        $data = $form->getData();
        if ($this->checkIfNotRegistered($data)){
            // Create user
            $this->createUser($form->getData());
            return $this->redirect()->toRoute('register' , array(
                'action' =>  'confirm'
            ));
        } else {
            $model = new ViewModel(array(
                'error' => 'You are already registered',
                'form'  => $form,
            ));
            $model->setTemplate('user/register/register');
            return $model;
        }
    }

    public function confirmAction()
    {
        return new ViewModel();
    }

    protected function checkIfNotRegistered(array $data)
    {
        $userTable = $this->getServiceLocator()->get('UserTable');
        if (($this->isEmailFree($data['email'], $userTable)) && ($this->isUsernameFree($data['username'], $userTable))) {
            return true;
        }
        return false;
    }

    private function isEmailFree($email, $userTable)
    {
        $isFree = $userTable->getUserByEmail($email) ? false : true;
        return $isFree;
    }

    private function isUsernameFree($username, $userTable)
    {
        $isFree = $userTable->getUserByUsername($username) ? false : true;
        return $isFree;
    }

    protected function createUser(array $data)
    {
        $user = new User();
        $user->exchangeArray($data);
        $user->setPassword($data['password']);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userTable->saveUser($user);
        return true;
    }
}