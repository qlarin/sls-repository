<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use User\Model\ListRow;

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

    public function detailsAction()
    {
        $this->layout('layout/anime_layout');
        $user = $this->getLoggedUser();
        $this->layout()->setVariable('user', $user);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $anime = $animeTable->getAnime($this->params()->fromRoute('id'));
        $form = $this->serviceLocator()->get('AddAnimeToListForm');
        return new ViewModel(array(
            'user' => $user,
            'anime' => $anime,
            'form' => $form,
        ));
    }

    public function addToListAction()
    {
        $this->layout('layout/anime_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('anime');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('AnimeCreateForm');
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => "There were one or more issues with your submission.",
                'form' => $form,
            ));
            $model->setTemplate('anime/anime/details');
            return $model;
        }
        $data = $form->getData();
        if ($this->checkIfNotExist($data)) {
            $this->addRowToList($form->getData());
            return $this->redirect()->toRoute('user');
        } else {
            $model = new ViewModel(array(
                'error' => 'You already added that anime to your list',
                'form' => $form,
            ));
            $model->setTemplate('anime/anime/details');
            return $model;
        }
    }

    private function checkIfNotExist(array $data)
    {
        $animeListTable = $this->getServiceLocator()->get('ListRowTable');
        $isFree = $animeListTable->getAnimeRowByIds($data['animeId'], $data['userId']) ? false : true;
        return $isFree;
    }

    protected function addRowToList(array $data)
    {
        $listRow = new ListRow();
        $listRow->exchangeArray($data);
        $animeListTable = $this->getServiceLocator()->get('ListRowTable');
        $animeListTable->saveRow($listRow);
        return true;
    }
}