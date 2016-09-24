<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class User implements ActiveRecordInterface
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
        $record = new self($pdoConnection);
        foreach ($fields as $fieldName => $value) {
            $record->$fieldName = $value;
        }
        $record->isPersisted = true;
        return $record;
    }

    public function delete()
    {
        $deleteSqlStringPattern = 'delete from %s where id = :id';
        $deleteSqlString = sprintf($deleteSqlStringPattern, $this->getTableName());
        $deleteStatement = $this->pdoConnection->prepare($deleteSqlString);
        $deleteStatement->execute([$this->id]);
    }

    public function save()
    {
        if ($this->isPersisted()) {
            $updateStatement = $this->pdoConnection->prepare("update `user` 
              set 
                login = :login, 
                email = :email, 
                password_hash = :password_hash
              where id = :id");
            $updateStatement->execute([$this->login, $this->email, $this->password_hash, $this->id]);
        } else {
            $insertStatement = $this->pdoConnection->prepare("insert into `user` 
              (login, email, password_hash) values (:login, :email, :password_hash)");
            $insertStatement->execute(['fooLogin', 'fooEmail', 'someHask']);
        }
    }

    public function isPersisted(): bool
    {
        return $this->isPersisted;
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