<?php

namespace User\Model;


class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $dor;
    public $dob;
    public $name;
    public $surname;
    public $location;
    public $avatarUrl;
    public $isAdmin;

    public function setPassword($clearPassword)
    {
        $this->password = md5($clearPassword);
    }

    public function setRegisterDate()
    {
        $date = new \DateTime();
        $this->dor = $date->format('Y-m-d');
    }

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->dob = (!empty($data['dob'])) ? $data['dob'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->surname = (!empty($data['surname'])) ? $data['surname'] : null;
        $this->location = (!empty($data['location'])) ? $data['location'] : null;
        $this->avatarUrl = (!empty($data['avatarUrl'])) ? $data['avatarUrl'] : null;
        $this->isAdmin = (!empty($data['isAdmin'])) ? $data['isAdmin'] : false;

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}