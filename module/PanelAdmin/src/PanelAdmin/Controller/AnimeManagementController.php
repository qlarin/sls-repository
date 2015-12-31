<?php

/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

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
        $viewModel  = new ViewModel(array(
            'animes' => $animeTable->fetchAll()
        ));
        return $viewModel;
    }

    public function createAction()
    {

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
            'id' => $this->params()->fromRoute('id')
        ));
        return $viewModel;
    }

    public function deleteAction()
    {
        $this->layout('layout/admin_layout');
        $this->getServiceLocator()->get('AnimeTable')
            ->deleteAnime($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute('admin/manage-animelist');
    }

    public function processAction()
    {
        $this->layout('layout/admin_layout');
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('admin/manage-animelist', array('action' => 'edit'));
        }
        $post = $this->request->getPost();
        $animeTable = $this->getServiceLocator()->get('AnimeTable');
        $anime = $animeTable->getAnime($post->id);
        $form = $this->getServiceLocator()->get('AnimeEditForm');
        $form->bind($anime);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, please enter correct data',
                'form' => $form,
            ));
            $model->setTemplate('admin/manage-animelist/edit');
            return $model;
        }

        $this->getServiceLocator()->get('AnimeTable')->saveAnime($anime);
        return $this->redirect()->toRoute('admin/manage-animelist');
    }
}