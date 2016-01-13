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
        $user = $userTable->getUser($userId);
        if (empty($user->id)) {
            return $this->redirect()->toRoute('anime');
        }
        $animeList = $animeListTable->fetchAllWithAnimeByUserId($userId);
        return new ViewModel(array(
            'loggedUser' => $this->loggedUser,
            'user' => $user,
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

    public function editRowAction()
    {
        $this->initLayout();
        $listRowTable = $this->getServiceLocator()->get('ListRowTable');
        $row = $listRowTable->getRowById($this->params()->fromRoute('id'));
        if (empty($this->loggedUser) || ($this->loggedUser->id !== $row->userId)) {
            return $this->redirect()->toRoute('anime');
        }
        $form = $this->getServiceLocator()->get('EditAnimeOnListForm');
        $form->bind($row);
        return new ViewModel(array(
            'user' => $this->loggedUser,
            'form' => $form,
            'id' => $row->id,
            'userId' => $row->userId,
            'animeId' => $row->animeId,
        ));
    }

    public function editRowProcessAction()
    {
        $this->initLayout();
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('list', array('id' => $this->loggedUser->id));
        }
        $post = $this->request->getPost();
        $listRowTable = $this->getServiceLocator()->get('ListRowTable');
        $row = $listRowTable->getRowById($post->id);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $form = $this->getServiceLocator()->get('EditAnimeOnListForm');
        $form->bind($row);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, please enter correct data',
                'form' => $form,
                'user' => $this->loggedUser,
                'id' => $post->id,
                'userId' => $post->userId,
                'animeId' => $post->animeId,
            ));
            $model->setTemplate('user/list/edit-row');
            return $model;
        }
        $data = $form->getData();
        if ($this->checkIfExceededMaxEpisodes($data, $animeTable)) {
            $model = new ViewModel(array(
                'error' => 'You cannot set more episodes than anime has',
                'form' => $form,
                'user' => $this->loggedUser,
                'id' => $post->id,
                'userId' => $post->userId,
                'animeId' => $post->animeId,
            ));
            $model->setTemplate('user/list/edit-row');
            return $model;
        }
        $this->getServiceLocator()->get('ListRowTable')->saveRow($row);
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

    private function checkIfExceededMaxEpisodes($data, $animeTable)
    {
        $exceed = false;
        $anime = $animeTable->getAnime($data->animeId);
        if ($data->episode > $anime->episodes)
        {
            $exceed = true;
        }
        return $exceed;
    }
}