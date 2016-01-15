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
}