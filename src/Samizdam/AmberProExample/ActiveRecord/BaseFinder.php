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

    public function getRecordById($id, \PDO $pdoConnection = null): ActiveRecordInterface
    {
        $selectByIdStatement = $this->pdoConnection->query('select * from ' . $this->tableName . ' where id = :id');
        $selectByIdStatement->execute([$id]);
        $rowData = $selectByIdStatement->fetch(\PDO::FETCH_ASSOC);
        $recordFactory = [$this->activeRecordClass, 'populate'];
        $pdoConnection = $pdoConnection ?: $this->pdoConnection;
        return call_user_func($recordFactory, $pdoConnection, $rowData);
    }
}