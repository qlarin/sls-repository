<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class MessageTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getMessage($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(function (Select $select) use ($id) {
            $select->join('user', 'message.authorId = user.id', array('username'));
            $select->where('message.id = ' . $id);
        });
        $row = $rowset->current();
        if (!$row) {
            return new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getMessagesByUserId($userId)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($userId) {
            $select->join('user', 'message.authorId = user.id', array('username'));
            $select->where('userId = ' . $userId);
            $select->order('id DESC');
        });
        return $rowset;
    }

    public function saveMessage(Message $message)
    {
        $data = array(
            'topic' => $message->topic,
            'body' => $message->body,
            'userId' => $message->userId,
            'authorId' => $message->authorId,
        );

        $id = (int) $message->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $message = $this->getMessage($id);
            if ($message) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Message id does not exist');
            }
        }
    }
}