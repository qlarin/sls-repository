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
        $this->layout()->setVariable('registerActive', 'active');
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
                'error' => true,
                'form'  => $form,
            ));
            $model->setTemplate('user/register/register');
            return $model;
        }
        // Create user
        $this->createUser($form->getData());
        return $this->redirect()->toRoute('register' , array(
            'action' =>  'confirm'
        ));
    }

    public function confirmAction()
    {
        return new ViewModel();
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