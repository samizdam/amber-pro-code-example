<?php

namespace Samizdam\AmberProExample\ActiveRecord\QueryBuilder;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseQueryBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildInsertQuery()
    {
        $queryBuilder = new BaseQueryBuilder();
        $sql = $queryBuilder->buildInsertQuery('user', ['name']);
        $expected = 'INSERT INTO `user` (`name`) VALUES (:name)';
        $this->assertEquals($expected, $sql);
    }
}