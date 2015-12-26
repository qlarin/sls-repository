<?php


namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array(
            'id' => $id,
        ));
        $row = $rowset->current();
        if (!$row) {
            return new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(User $user)
    {
        $data = array(
            'username' => $user->username,
            'password' => $user->password,
            'email' => $user->email,
            'dor' => $user->dor,
            'dob' => $user->dob,
            'name' => $user->name,
            'surname' => $user->surname,
            'location' => $user->location,
            'avatar_id' => $user->avatarId,
            'isAdmin' => $user->isAdmin,
        );

        $id = (int) $user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $user = $this->getUser($id);
            if ($user) {
                if (empty($data['password'])) {
                    unset($data['password']);
                }
                $data['username'] = $user->username;
                $data['email'] = $user->email;
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('User id does not exist');
            }
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id,
        ));
    }

    public function getUserByEmail($userEmail)
    {
        $rowset = $this->tableGateway->select(array(
            'email' => $userEmail
        ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function getUserByUsername($username)
    {
        $rowset = $this->tableGateway->select(array(
            'username' => $username
        ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

}