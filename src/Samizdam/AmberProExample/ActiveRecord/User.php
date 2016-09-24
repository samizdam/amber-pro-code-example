<?php

namespace Samizdam\AmberProExample\ActiveRecord;

use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\BaseQueryBuilder;
use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\QueryBuilderFactory;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class User extends AbstractActiverRecord
{

    public function delete()
    {
        $deleteSqlStringPattern = 'delete from %s where id = :id';
        $deleteSqlString = sprintf($deleteSqlStringPattern, $this->getTableName());
        $deleteStatement = $this->getConnection()->prepare($deleteSqlString);
        $deleteStatement->execute([$this->id]);
    }

    public function save()
    {
        $queryBuilder = QueryBuilderFactory::getQueryBuilder($this->getConnection());
        if ($this->isPersisted()) {
            $updateStatement = $this->getConnection()->prepare("update `user` 
              set 
                login = :login, 
                email = :email, 
                password_hash = :password_hash
              where id = :id");
            $updateStatement->execute([$this->login, $this->email, $this->password_hash, $this->id]);
        } else {
            $recordFields = get_object_vars($this);
            $columnsNames = array_keys($recordFields);
            $insertSql = $queryBuilder->buildInsertQuery(static::getTableName(), $columnsNames);
            $insertStatement = $this->getConnection()->prepare($insertSql);
            $insertStatement->execute($recordFields);
        }
    }

    public static function getTableName(): string
    {
        return 'user';
    }

    public static function getFinder(\PDO $pdoConnection): FinderInterface
    {
        return new BaseFinder($pdoConnection, static::class);
    }
}