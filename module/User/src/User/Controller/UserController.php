<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/layout');
        $this->layout()->setVariable('userActive', 'active');
        return new ViewModel();
    }
}