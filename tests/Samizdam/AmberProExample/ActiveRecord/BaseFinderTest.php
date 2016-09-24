<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseFinderTest extends AbstractDbTestCase
{

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

    public function testGetRecordByIdWithAnotherConnection()
    {
        $finder = new BaseFinder($this->pdoConnection, User::class);
        $record = $finder->getRecordById(1, new \PDO('sqlite::memory:'));
        $this->assertNotSame($this->pdoConnection, $record->getConnection());
    }
}