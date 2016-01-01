<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;


class Character
{
    public $id;
    public $name;
    public $surname;
    public $dob;
    public $imageUrl;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->surname = (!empty($data['surname'])) ? $data['surname'] : null;
        $this->dob = (!empty($data['dob'])) ? $data['dob'] : null;
        $this->imageUrl = (!empty($data['imageUrl'])) ? $data['imageUrl'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}