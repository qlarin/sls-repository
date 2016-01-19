<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class UserController extends AbstractActionController
{

    protected $authService;

    public function indexAction()
    {
        $this->layout('layout/user_layout');
        $user = $this->getLoggedUser();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $viewModel  = new ViewModel(array('user' => $user));
        return $viewModel;
    }

    public function editAction()
    {
        $this->layout('layout/user_layout');
        $user = $this->getLoggedUser();
        if (empty($user)) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setVariable('user', $user);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $viewModel  = new ViewModel(array(
            'form' => $form,
            'id' => $this->params()->fromRoute('id'),
            'user' => $user,
        ));
        return $viewModel;
    }
    public function processAction()
    {
        $this->layout('layout/user_layout');

        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('user', array('action' => 'edit'));
        }
        $files = $this->request->getFiles();
        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($post->id);
        $oldUrl = $user->avatarUrl;
        $newUrl = $files->avatarUrl;
        if (!empty($newUrl['name'])) {
            if (!$this->checkIfImagesEqual($oldUrl, $newUrl)) {
                $post = array_merge_recursive(
                    $this->request->getPost()->toArray(),
                    $files->toArray()
                );
            }
        }
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => 'Something goes wrong, try one more time!',
                'form'  => $form,
                'user' => $user,
            ));
            $model->setTemplate('user/edit');
            return $model;
        }
        $data = $form->getData();
        if (!empty($newUrl['name']) && $this->checkIfImagesEqual($oldUrl, $newUrl) == false) {
            $data->avatarUrl = substr($data->avatarUrl['tmp_name'], 7);
        } else {
            $data->avatarUrl = $oldUrl;
        }
        $this->getServiceLocator()->get('UserTable')->saveUser($user);
        return $this->redirect()->toRoute('user');
    }

    private function getLoggedUser()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        return $user;
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
}