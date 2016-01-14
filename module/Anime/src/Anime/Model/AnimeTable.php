<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class AnimeTable
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

    public function getAnime($id)
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

    public function getRecentlyAddedAnimes()
    {
        $rowset = $this->tableGateway->select(function (Select $select) {
           $select->order('id DESC')->limit(4);
        });
        return $rowset;
    }

    public function getPreviousAnime($id)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($id) {
            $select->where('id = (select max(id) from anime where id < ' . $id . ')');
        });
        return $rowset->current();
    }

    public function getNextAnime($id)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($id) {
            $select->where('id = (select min(id) from anime where id > ' . $id . ')');
        });
        return $rowset->current();
    }

    public function saveAnime(Anime $anime)
    {
        $data = array(
            'title' => $anime->title,
            'synopsis' => $anime->synopsis,
            'tags' => $anime->tags,
            'countRating' => $anime->countRating,
            'avgRating' => $anime->avgRating,
            'prequel' => $anime->prequel,
            'sequel' => $anime->sequel,
            'spinoff' => $anime->spinoff,
            'episodes' => $anime->episodes,
            'imageUrl' => $anime->imageUrl,
        );

        $id = (int) $anime->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $anime = $this->getAnime($id);
            if ($anime) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Anime id does not exist');
            }
        }
    }

    public function deleteAnime($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id,
        ));
    }

    public function getAnimeByTitle($title)
    {
        $rowset = $this->tableGateway->select(array(
            'title' => $title
        ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
}