<?php

namespace Samizdam\AmberProExample\ActiveRecord;

use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class UserTest extends \PHPUnit_Extensions_Database_TestCase
{

    private $pdoConnection;

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

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createArrayDataSet([
            'user' => [
                [
                    'id' => 1,
                    'login' => 'Foobar',
                    'email' => 'foo@bar',
                    'password_hash' => '$2y$11$q5MkhSBtlsJcNEVsYh64a.aCluzHnGog7TQAKVmQwO9C8xb.t89F.'
                ]
            ]
        ]);
    }

    public function testSaveNewInstance()
    {
        $this->assertTableRowCount('user', 1);
        $user = new User($this->pdoConnection);
        $user->save();
        $this->assertTableRowCount('user', 2);
    }

    public function testDelete()
    {
        $user = User::getFinder($this->pdoConnection)->getRecordById(1);
        $user->delete();
        $this->assertTableRowCount('user', 0);
    }
}