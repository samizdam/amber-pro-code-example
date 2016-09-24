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

    public function save()
    {
        if ($this->isPersisted()) {
            $updateStatement = $this->getConnection()->prepare("update `user` 
              set 
                login = :login, 
                email = :email, 
                password_hash = :password_hash
              where id = :id");
            $updateStatement->execute([$this->login, $this->email, $this->password_hash, $this->id]);
        } else {
            $insertStatement = $this->getConnection()->prepare("insert into `user` 
              (login, email, password_hash) values (:login, :email, :password_hash)");
            $insertStatement->execute(['fooLogin', 'fooEmail', 'someHask']);
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