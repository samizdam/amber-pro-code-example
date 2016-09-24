<?php

namespace Samizdam\AmberProExample\ActiveRecord;

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

    public static function getTableName(): string
    {
        return 'user';
    }

    public static function getPrimaryKeyColumns(): array
    {
        return ['id'];
    }

    public static function getFinder(\PDO $pdoConnection): FinderInterface
    {
        return new BaseFinder($pdoConnection, static::class);
    }
}