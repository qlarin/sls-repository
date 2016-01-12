<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ListRowTable
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

    public function deleteRow($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id,
        ));
    }

    public function getRowById($id)
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

    public function getListByUserId($userId)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($userId) {
            $select->where('userId = ' . $userId);
        });
        return $rowset->buffer();
    }

    public function fetchAllWithAnimeByUserId($userId)
    {
        $result = $this->tableGateway->select(function (Select $select) use ($userId) {
            $select->join('anime', 'list_row.animeId = anime.id', array('title', 'episodes'))
            ->where('userId = ' . $userId);
        });
        return $result->buffer();
    }

    public function saveRow(Row $row)
    {
        $data = array (
            'id' => $row->id,
            'episode' => $row->episode,
            'rating' => $row->rating,
            'status' => $row->status,
            'userId' => $row->userId,
            'animeId' => $row->animeId,
        );

        $id = (int) $row->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $row = $this->getRowById($id);
            if ($row) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Row id does not exist');
            }
        }
    }

    public function getAnimeRowByIds($animeId, $userId)
    {
        $rowset = $this->tableGateway->select(array(
            'animeId' => $animeId,
            'userId' => $userId
        ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

}