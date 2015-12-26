<?php
/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/admin_layout');
        $user = $this->getLoggedUser();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->checkIfAdmin($user);
        $this->layout()->setVariable('user', $user);
        $viewModel  = new ViewModel(array('user' => $user));
        return $viewModel;
    }

    private function getLoggedUser()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        return $user;
    }

    private function checkIfAdmin($user)
    {
        if (!$user->isAdmin) {
            return $this->redirect()->toRoute('user');
        }
    }
}