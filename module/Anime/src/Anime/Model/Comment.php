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

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->body = (!empty($data['body'])) ? $data['body'] : null;
        $this->authorId = (!empty($data['authorId'])) ? $data['authorId'] : null;
        $this->animeId = (!empty($data['animeId'])) ? $data['animeId'] : null;

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}