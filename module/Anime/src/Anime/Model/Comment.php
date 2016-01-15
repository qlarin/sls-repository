<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;


class Comment
{
    public $id;
    public $body;
    public $authorId;
    public $animeId;

    public $username;
    public $isAdmin;
    public $avatarUrl;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->body = (!empty($data['body'])) ? $data['body'] : null;
        $this->authorId = (!empty($data['authorId'])) ? $data['authorId'] : null;
        $this->animeId = (!empty($data['animeId'])) ? $data['animeId'] : null;

        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->isAdmin = (!empty($data['isAdmin'])) ? $data['isAdmin'] : null;
        $this->avatarUrl = (!empty($data['avatarUrl'])) ? $data['avatarUrl'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}