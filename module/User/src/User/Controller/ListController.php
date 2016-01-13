<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class ListController extends AbstractActionController
{
    private $loggedUser;

    public function animeAction()
    {
        $this->initLayout();
        $animeListTable = $this->getServiceLocator()->get('ListRowTable');
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userId = $this->params()->fromRoute('id');
        $animeList = $animeListTable->fetchAllWithAnimeByUserId($userId);
        return new ViewModel(array(
            'loggedUser' => $this->loggedUser,
            'user' => $userTable->getUser($userId),
            'animeList' => $animeList,
        ));
    }

    public function deleteAction()
    {
        $this->initLayout();
        $this->getServiceLocator()->get('ListRowTable')
            ->deleteRow($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute('list', array('id' => $this->loggedUser->id));
    }

    private function initLayout()
    {
        $this->layout('layout/user_layout');
        $this->loggedUser = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (!empty($this->loggedUser)) {
            $this->layout()->setVariable('user', $this->loggedUser);
        }
    }

}