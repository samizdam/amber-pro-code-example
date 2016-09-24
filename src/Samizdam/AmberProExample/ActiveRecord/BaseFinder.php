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
    private $primaryKeyColumns;

    public function __construct(\PDO $pdoConnection, string $activeRecordClass)
    {
        $this->pdoConnection = $pdoConnection;
        $this->activeRecordClass = $activeRecordClass;
        $this->tableName = call_user_func([$activeRecordClass, 'getTableName']);
        $this->primaryKeyColumns = call_user_func([$activeRecordClass, 'getPrimaryKeyColumns']);
        $this->queryBuilder = QueryBuilderFactory::getQueryBuilder($this->pdoConnection);
    }

    public function getRecordByPK($pkValue, \PDO $recordInstansPdoConnection = null): ActiveRecordInterface
    {
        $selectSql = $this->queryBuilder->buildSelectAllQuery($this->tableName, $this->primaryKeyColumns);
        $selectByIdStatement = $this->pdoConnection->query($selectSql);
        $selectByIdStatement->execute([$pkValue]);
        $rowData = $selectByIdStatement->fetch(\PDO::FETCH_ASSOC);
        $recordFactory = [$this->activeRecordClass, 'populate'];
        $recordInstansPdoConnection = $recordInstansPdoConnection ?: $this->pdoConnection;
        return call_user_func($recordFactory, $recordInstansPdoConnection, $rowData);
    }
}