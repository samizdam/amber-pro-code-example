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

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function save()
    {
        if($this->isPersisted()) {

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
}