<?php

namespace Samizdam\AmberProExample\ActiveRecord;

use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\QueryBuilderFactory;

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
    private $queryBuilder;

    public function __construct(\PDO $pdoConnection, string $activeRecordClass)
    {
        $this->pdoConnection = $pdoConnection;
        $this->activeRecordClass = $activeRecordClass;
        $this->tableName = call_user_func([$activeRecordClass, 'getTableName']);
        $this->queryBuilder = QueryBuilderFactory::getQueryBuilder($this->pdoConnection);
    }

    public function getRecordById($id, \PDO $recordInstansPdoConnection = null): ActiveRecordInterface
    {
        $selectSql = $this->queryBuilder->buildSelectAllQuery($this->tableName, ['id']);
        $selectByIdStatement = $this->pdoConnection->query($selectSql);
        $selectByIdStatement->execute([$id]);
        $rowData = $selectByIdStatement->fetch(\PDO::FETCH_ASSOC);
        $recordFactory = [$this->activeRecordClass, 'populate'];
        $recordInstansPdoConnection = $recordInstansPdoConnection ?: $this->pdoConnection;
        return call_user_func($recordFactory, $recordInstansPdoConnection, $rowData);
    }
}