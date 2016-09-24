<?php

namespace Samizdam\AmberProExample\ActiveRecord;

use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\QueryBuilderFactory;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractActiverRecord implements ActiveRecordInterface
{

    /**
     * @var \PDO
     */
    private $pdoConnection;
    private $isPersisted = false;

    public function __construct(\PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public static function populate(\PDO $pdoConnection, array $fields)
    {
        $record = new static($pdoConnection);
        foreach ($fields as $fieldName => $value) {
            $record->$fieldName = $value;
        }
        $record->isPersisted = true;
        return $record;
    }

    protected function toArray(): array
    {
        return (new Hydrator())->hydrate($this);
    }

    public function save()
    {
        $queryBuilder = QueryBuilderFactory::getQueryBuilder($this->getConnection());
        $recordFields = static::toArray();
        $columnsNames = array_keys($recordFields);
        if ($this->isPersisted()) {
            $updateSql = $queryBuilder->buildUpdateQuery(static::getTableName(), $columnsNames,
                static::getPrimaryKeyColumns());
            $updateStatement = $this->getConnection()->prepare($updateSql);
            $updateStatement->execute($recordFields);
        } else {
            $insertSql = $queryBuilder->buildInsertQuery(static::getTableName(), $columnsNames);
            $insertStatement = $this->getConnection()->prepare($insertSql);
            $insertStatement->execute($recordFields);
        }
    }

    public function getConnection(): \PDO
    {
        return $this->pdoConnection;
    }

    public function isPersisted(): bool
    {
        return $this->isPersisted;
    }
}