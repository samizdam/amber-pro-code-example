<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseFinder implements FinderInterface
{
    /**
     * @var \PDO
     */
    private $pdoConnection;
    /**
     * @var string
     */
    private $activeRecordClass;
    private $tableName;

    public function __construct(\PDO $pdoConnection, string $activeRecordClass)
    {
        $this->pdoConnection = $pdoConnection;
        $this->activeRecordClass = $activeRecordClass;
        $this->tableName = call_user_func([$activeRecordClass, 'getTableName']);
    }

    public function getRecordById($id): ActiveRecordInterface
    {
        $selectByIdStatement = $this->pdoConnection->query('select * from ' . $this->tableName .' where id = :id');
        $selectByIdStatement->setFetchMode(\PDO::FETCH_CLASS, $this->activeRecordClass, [$this->pdoConnection]);
        $selectByIdStatement->execute([$id]);
        return $selectByIdStatement->fetch();
    }
}