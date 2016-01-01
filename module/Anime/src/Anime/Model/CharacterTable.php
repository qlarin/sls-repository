<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;

use Zend\Db\TableGateway\TableGateway;

class CharacterTable
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

    public function getCharacter($id)
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

    public function saveCharacter(Character $character)
    {
        $data = array(
            'name' => $character->name,
            'surname' => $character->surname,
            'dob' => $character->dob,
            'imageUrl' => $character->imageUrl,
        );

        $id = (int) $character->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $character = $this->getCharacter($id);
            if ($character) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Character id does not exist');
            }
        }
    }

    public function deleteCharacter($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id,
        ));
    }

    public function getCharacterByName($name)
    {
        $rowset = $this->tableGateway->select(array(
            'name' => $name
        ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
}