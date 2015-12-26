<?php

/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller\PanelAdmin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AnimeManagementController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/user_layout');
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $viewModel  = new ViewModel(array('user' => $user));
        return $viewModel;
    }
}