<?php

/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Anime\Model\Anime;

class AnimeManagementController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/admin_layout');
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $results = $animeTable->fetchAll(true);
        $results->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        $results->setItemCountPerPage(10);

        $viewModel  = new ViewModel(array(
            'animes' => $results
        ));
        return $viewModel;
    }

    protected function initLayout()
    {
        $this->layout('layout/admin_layout');
        $admin = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($admin)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $admin);
    }

    public function createAction()
    {
        $this->initLayout();
        $form = $this->getServiceLocator()->get('AnimeCreateForm');
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function createProcessAction()
    {
        $this->layout('layout/admin_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('admin/manage-anime', array('action' => 'create'));
        }
        $post = array_merge_recursive(
            $this->request->getPost()->toArray(),
            $this->request->getFiles()->toArray()
        );
        $form = $this->getServiceLocator()->get('AnimeCreateForm');
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => "There were one or more issues with your submission.",
                'form' => $form,
            ));
            $model->setTemplate('panel-admin/anime-management/create');
            return $model;
        }
        $data = $form->getData();
        if ($this->checkIfNotExist($data)) {
            $this->createAnime($form->getData());
            return $this->redirect()->toRoute('admin');
        } else {
            $model = new ViewModel(array(
                'error' => 'An anime is already added in DB',
                'form' => $form,
            ));
            $model->setTemplate('panel-admin/anime-management/create');
            return $model;
        }
    }

    public function editAction()
    {
        $this->layout('layout/admin_layout');
        $admin = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if (empty($admin)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $admin);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $anime = $animeTable->getAnime($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('AnimeEditForm');
        $form->bind($anime);
        $viewModel = new ViewModel(array(
            'form' => $form,
            'id' => $this->params()->fromRoute('id'),
            'anime' => $anime,
        ));
        return $viewModel;
    }

    public function deleteAction()
    {
        $this->layout('layout/admin_layout');
        $this->getServiceLocator()->get('AnimeTable')
            ->deleteAnime($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute('admin/manage-anime');
    }

    public function processAction()
    {
        $this->layout('layout/admin_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('admin/manage-anime', array('action' => 'edit'));
        }
        $files = $this->request->getFiles();
        $post = $this->request->getPost();
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $anime = $animeTable->getAnime($post['id']);
        $oldUrl = $anime->imageUrl;
        $newUrl = $files->imageUrl;
        if (!empty($newUrl['name'])) {
            if (!$this->checkIfImagesEqual($oldUrl, $newUrl)) {
                $post = array_merge_recursive(
                    $this->request->getPost()->toArray(),
                    $files->toArray()
                );
            }
        }
        $form = $this->getServiceLocator()->get('AnimeEditForm');
        $form->bind($anime);
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, please enter correct data',
                'form' => $form,
                'anime' => $anime,
            ));
            $model->setTemplate('panel-admin/anime-management/edit');
        }
        $data = $form->getData();
        if (!empty($newUrl['name']) && $this->checkIfImagesEqual($oldUrl, $newUrl) == false) {
            $data->imageUrl = substr($data->imageUrl['tmp_name'], 7);
        } else {
            $data->imageUrl = $oldUrl;
        }

        $this->getServiceLocator()->get('AnimeTable')->saveAnime($anime);
        return $this->redirect()->toRoute('admin/manage-anime');
    }

    private function checkIfNotExist(array $data)
    {
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $isFree = $animeTable->getAnimeByTitle($data['title']) ? false : true;
        return $isFree;
    }

    private function decodeImageName($oldUrl)
    {
        $oldUrl = substr($oldUrl, 0, strpos($oldUrl, '_'));
        return substr($oldUrl, 10);
    }

    private function checkIfImagesEqual($oldUrl, $newUrl)
    {
        $equal = false;
        $oldName = $this->decodeImageName($oldUrl);
        $newName = strstr($newUrl['name'], '.', true);
        if (strpos($newName, '_') !== false) {
            $newName = substr($newUrl['name'], 0, strpos($newName, '_'));
        }
        if ($oldName === $newName) {
            $equal = true;
        }
        return $equal;
    }

    protected function createAnime(array $data)
    {
        $anime = new Anime();
        $img = $data['imageUrl']['tmp_name'];
        $data['imageUrl'] = substr($img, 7);
        $anime->exchangeArray($data);
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $animeTable->saveAnime($anime);
        return true;
    }
}