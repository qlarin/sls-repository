<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class ListController extends AbstractActionController
{
    private function getLoggedUser()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        return $user;
    }

    public function listAction()
    {
        $this->layout('layout/anime_layout');
        $user = $this->getLoggedUser();
        $this->layout()->setVariable('user', $user);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $results = $animeTable->fetchAll(true);
        $results->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        $results->setItemCountPerPage(10);

        return new ViewModel(array(
            'user' => $user,
            'results' => $results,
        ));

    }
}