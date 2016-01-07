<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AnimeController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/anime_layout');
        $user = $this->getLoggedUser();
        $this->layout()->setVariable('user', $user);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        return new ViewModel(array(
            'user' => $user,
            'animes' => $animeTable->getRecentlyAddedAnimes(),
        ));
    }

    private function getLoggedUser()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        return $user;
    }
}