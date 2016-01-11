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
        var_dump($animeList);
        return new ViewModel(array(
            'loggedUser' => $this->loggedUser,
            'user' => $userTable->getUser($userId),
            'animeList' => $animeList,
        ));
    }

    private function prepareFinalList($animeList) {
        $animesId = array();
        foreach ($animeList as $animeRow) {
            $animesId[] = $animeRow->animeId;
        }


        var_dump($animesId);
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