<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Model;


class ListRow
{

    public $id;
    public $episode;
    public $rating;
    public $status;
    public $userId;
    public $animeId;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->episode = (!empty($data['episode'])) ? $data['episode'] : null;
        $this->rating = (!empty($data['rating'])) ? $data['rating'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->userId = (!empty($data['userId'])) ? $data['userId'] : null;
        $this->animeId = (!empty($data['animeId'])) ? $data['animeId'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}