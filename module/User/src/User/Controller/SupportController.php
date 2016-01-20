<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use User\Model\Message;
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
        $this->layout('layout/user-layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('user');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('MessageForm');
        $form->setData($post);
        if (!$form->isValid()) {
            return $this->forward()->dispatch('User\Controller\Support', array(
                'action' => 'mailbox',
                'error' => 'There were one or more issues with your submission.',
                'id' => $form->getData()['authorId']
            ));
        }
        $data = $form->getData();
        $this->sendTicket($data);
        return $this->redirect()->toRoute('support', array(
            'action' => 'mailbox',
            'id' => $data['authorId']
        ));
    }

    public function detailsAction()
    {
        $this->initLayout();
        $oldMessageId = $this->getEvent()->getRouteMatch()->getParam('oldMessageId');
        $messageTable = $this->getServiceLocator()->get('MessageTable');
        if (empty($oldMessageId)) {
            $message = $messageTable->getMessage($this->params()->fromRoute('id'));
        } else {
            $message = $messageTable->getMessage($oldMessageId);
        }
        if ($this->loggedUser->id != $message->userId) {
            return $this->redirect()->toRoute('login');
        }
        $error = $this->getEvent()->getRouteMatch()->getParam('error');
        $replyForm = $this->getServiceLocator()->get('ReplyForm');

        return new ViewModel(array(
            'user' => $this->loggedUser,
            'error' => $error,
            'mail' => $message,
            'form' => $replyForm,
        ));
    }

    public function replyProcessAction()
    {
        $this->layout('layout/user-layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('user');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('ReplyForm');
        $form->setData($post);
        if (!$form->isValid()) {
            return $this->forward()->dispatch('User\Controller\Support', array(
                'action' => 'details',
                'error' => 'There were one or more issues with your submission.',
                'oldMessageId' => $form->getData()['oldMessageId']
            ));
        }
        $data = $form->getData();
        $data['topic'] = 'Re: ' . $data['topic'];
        $this->sendTicket($data);
        return $this->redirect()->toRoute('support', array(
            'action' => 'mailbox',
            'id' => $data['authorId']
        ));
    }

    private function sendTicket(array $data)
    {
        $ticket = new Message();
        $ticket->exchangeArray($data);
        $messageTable = $this->getServiceLocator()->get('MessageTable');
        $messageTable->saveMessage($ticket);
        return true;
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