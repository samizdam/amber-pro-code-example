<?php

namespace Samizdam\AmberProExample\ActiveRecord;


use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractDbTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    protected $pdoConnection;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->pdoConnection = new \PDO('sqlite::memory:');
        $this->pdoConnection->query(<<<SQL
            CREATE TABLE user (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               login VARCHAR(255) NOT NULL UNIQUE,
               email VARCHAR(255) NOT NULL ,
               password_hash VARCHAR(60) NOT NULL
   );
SQL
        );
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        return $this->createDefaultDBConnection($this->pdoConnection);
    }

}