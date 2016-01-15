<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Controller;

use Anime\Model\Comment;
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
            'topRatedAnimes' => $animeTable->getTopRatedAnimes(),
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
        $commentTable = $this->getServiceLocator()->get('CommentTable');
        $comments = $commentTable->getCommentsByAnimeId($this->params()->fromRoute('id'));
        $error = $this->getEvent()->getRouteMatch()->getParam('error');
        $form = $this->getServiceLocator()->get('AddAnimeToListForm');
        $commentForm = $this->getServiceLocator()->get('AddCommentForm');
        return new ViewModel(array(
            'user' => $user,
            'anime' => $anime,
            'comments' => $comments,
            'form' => $form,
            'commentForm' => $commentForm,
            'error' => $error,
            'prev' => $animeTable->getPreviousAnime($anime->id),
            'next' => $animeTable->getNextAnime($anime->id),
        ));
    }

    public function addToListProcessAction()
    {
        $this->layout('layout/anime_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('anime');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('AddAnimeToListForm');
        $form->setData($post);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        if (!$form->isValid()) {
            return $this->forward()->dispatch('Anime\Controller\Anime', array(
                'action' => 'details',
                'error' => 'There were one or more issues with your submission.',
                'id' => $form->getData()['animeId']
            ));
        }
        $data = $form->getData();
        if ($this->checkIfExceededMaxEpisodes($data, $animeTable)) {
            return $this->forward()->dispatch('Anime\Controller\Anime', array(
                'action' => 'details',
                'error' => 'You cannot set more episodes than anime has.',
                'id' => $data['animeId']
            ));
        }
        if ($this->checkIfNotExist($data)) {
            $this->addRowToList($form->getData());
            $this->checkRating($data);
            return $this->redirect()->toRoute('user');
        } else {
            return $this->forward()->dispatch('Anime\Controller\Anime', array(
                'action' => 'details',
                'error' => 'You already added that anime to your list.',
                'id' => $data['animeId']
            ));
        }
    }

    public function addCommentProcessAction()
    {
        $this->layout('layout/anime_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('anime');
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('AddCommentForm');
        $form->setData($post);
        if (!$form->isValid()) {
            return $this->forward()->dispatch('Anime\Controller\Anime', array(
                'action' => 'details',
                'error' => 'There were one or more issues with your submission.',
                'id' => $form->getData()['animeId']
            ));
        }
        $data = $form->getData();
        $this->addComment($data);
        return $this->redirect()->toRoute('anime', array(
            'action' => 'details',
            'id' => $data['animeId']
        ));
    }

    private function checkIfExceededMaxEpisodes(array $data, $animeTable)
    {
        $exceed = false;
        $anime = $animeTable->getAnime($data['animeId']);
        if ($data['episode'] > $anime->episodes)
        {
            $exceed = true;
        }
        return $exceed;
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

    protected function checkRating(array $data)
    {
        $animeListTable = $this->getServiceLocator()->get('ListRowTable');
        $result = $animeListTable->calculateRating($data['animeId']);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $anime = $animeTable->getAnime($data['animeId']);
        if (!empty($result)) {
            $anime->avgRating = floatval($result->rating);
            $anime->countRating = intval($result->count);
        } else if ($anime->avgRating == 0) {
            $anime->countRating = 0;
        }
        $animeTable->saveAnime($anime);
    }

    protected function addComment(array $data)
    {
        $comment = new Comment();
        $comment->exchangeArray($data);
        $commentTable = $this->getServiceLocator()->get('CommentTable');
        $commentTable->saveComment($comment);
        return true;
    }

}