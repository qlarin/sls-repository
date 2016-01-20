<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class CommentTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getComment($id)
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

    public function getCommentsByAnimeId($animeId)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($animeId) {
            $select->join('user', 'comment.authorId = user.id', array('username', 'isAdmin', 'avatarUrl'));
            $select->where('animeId = ' . $animeId);
            $select->order('animeId DESC')->limit(8);
        });
        return $rowset;
    }

    public function getLastCommentsByUserId($userId)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($userId) {
            $select->join('anime', 'comment.animeId = anime.id', array('title'));
            $select->where('authorId = ' . $userId);
            $select->order('id DESC')->limit(2);
        });
        return $rowset;
    }

    public function saveComment(Comment $comment)
    {
        $data = array(
            'body' => $comment->body,
            'animeId' => $comment->animeId,
            'authorId' => $comment->authorId,
        );

        $id = (int) $comment->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $comment = $this->getComment($id);
            if ($comment) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Comment id does not exist');
            }
        }
    }
}