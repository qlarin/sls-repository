<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Model;


class Message
{
    public $id;
    public $topic;
    public $body;
    public $authorId;
    public $userId;

    public $username;
    public $oldMessageId;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->topic = (!empty($data['topic'])) ? $data['topic'] : null;
        $this->body = (!empty($data['body'])) ? $data['body'] : null;
        $this->authorId = (!empty($data['authorId'])) ? $data['authorId'] : null;
        $this->userId = (!empty($data['userId'])) ? $data['userId'] : null;

        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->oldMessageId = (!empty($data['oldMessageId'])) ? $data['oldMessageId'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}