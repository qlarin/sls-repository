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
    private $user;

    public function animeAction()
    {
        $this->initLayout();
        $animeListTable = $this->getServiceLocator()->get('ListRowTable');
        $userId = $this->params()->fromRoute('id');
        return new ViewModel(array(
            'user' => $this->user,
            'animeList' => $animeListTable->getListByUserId($userId),
        ));
    }

    private function initLayout()
    {
        $this->layout('layout/user_layout');
        $this->user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (!empty($this->user)) {
            $this->layout()->setVariable('user', $this->user);
        }
    }

}