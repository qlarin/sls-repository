<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class RegisterController extends AbstractActionController
{
    public function registerAction()
    {
        return new ViewModel();
    }
}