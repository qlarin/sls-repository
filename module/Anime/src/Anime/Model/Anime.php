<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;


class Anime
{
    public $id;
    public $title;
    public $synopsis;
    public $tags;
    public $avgRating;
    public $prequel;
    public $sequel;
    public $spinoff;
    public $episodes;
    public $imageUrl;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->synopsis = (!empty($data['synopsis'])) ? $data['synopsis'] : null;
        $this->tags = (!empty($data['tags'])) ? $data['tags'] : null;
        $this->avgRating = (!empty($data['avgRating'])) ? $data['avgRating'] : null;
        $this->prequel = (!empty($data['prequel'])) ? $data['prequel'] : null;
        $this->sequel = (!empty($data['sequel'])) ? $data['sequel'] : null;
        $this->spinoff = (!empty($data['spinoff'])) ? $data['spinoff'] : null;
        $this->episodes = (!empty($data['episodes'])) ? $data['episodes'] : null;
        $this->imageUrl = (!empty($data['imageUrl'])) ? $data['imageUrl'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}