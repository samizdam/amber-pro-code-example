<?php

namespace Samizdam\AmberProExample\ActiveRecord;

use PHPUnit_Extensions_Database_DataSet_IDataSet;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class UserTest extends AbstractDbTestCase
{
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
        $user->login = 'Amba';
        $user->password_hash = 'some_hash';
        $user->email = 'amba@com';
        $user->save();
        $newPersistedUser = User::getFinder($this->pdoConnection)->getRecordById(2);
        $this->assertEquals('Amba', $newPersistedUser->login);
    }

    public function testDelete()
    {
        $user = User::getFinder($this->pdoConnection)->getRecordById(1);
        $user->delete();
        $this->assertTableRowCount('user', 0);
    }

    public function testSaveOnExistsRecord()
    {
        $user = User::getFinder($this->pdoConnection)->getRecordById(1);
        $user->login = 'Octocat';
        $user->save();
        $userAfterSave = User::getFinder($this->pdoConnection)->getRecordById(1);
        $this->assertEquals('Octocat', $userAfterSave->login);
    }
}