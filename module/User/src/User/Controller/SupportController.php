<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class SupportController extends AbstractActionController
{
    private $loggedUser;

    public function mailboxAction()
    {
        $this->initLayout();
        $mailListTable = $this->getServiceLocator()->get('MessageTable');
        $mailList = $mailListTable->getMessagesByUserId($this->loggedUser->id);
        $error = $this->getEvent()->getRouteMatch()->getParam('error');
        $form = $this->getServiceLocator()->get('MessageForm');

        return new ViewModel(array(
            'user' => $this->loggedUser,
            'error' => $error,
            'mailList' => $mailList,
            'form' => $form,
        ));
    }

    public function sendTicketProcessAction()
    {

    }


    private function initLayout()
    {
        $this->layout('layout/user_layout');
        $this->loggedUser = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (!empty($this->loggedUser)) {
            $this->layout()->setVariable('user', $this->loggedUser);
        } else {
            return $this->redirect()->toRoute('login');
        }
    }
}