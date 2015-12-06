<?php

namespace User\Model;


class User
{
    public $id;
    public $nickname;
    public $password;
    public $role;
    public $dor;
    public $dob;
    public $name;
    public $surname;
    public $location;
    public $avatarId;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nickname = (!empty($data['nickname'])) ? $data['nickname'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->role = (!empty($data['role'])) ? $data['role'] : null;
        $this->dor = (!empty($data['dor'])) ? $data['dor'] : null;
        $this->dob = (!empty($data['dob'])) ? $data['dob'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->surname = (!empty($data['surname'])) ? $data['surname'] : null;
        $this->location = (!empty($data['location'])) ? $data['location'] : null;
        $this->avatarId = (!empty($data['avatar_id'])) ? $data['avatar_id'] : null;
    }
}