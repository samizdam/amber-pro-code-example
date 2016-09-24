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

    public function testBuildSelectAllQuery()
    {
        $queryBuilder = new BaseQueryBuilder();
        $sql = $queryBuilder->buildSelectAllQuery('user', ['id']);
        $expected = 'SELECT * FROM `user` WHERE 1 AND `id` = :id';
        $this->assertEquals($expected, $sql);
    }

    public function testBuildUpdateQuery()
    {
        $queryBuilder = new BaseQueryBuilder();
        $sql = $queryBuilder->buildUpdateQuery('user', ['name'], ['id']);
        $expected = 'UPDATE `user` SET `name` = :name WHERE 1 AND `id` = :id';
        $this->assertEquals($expected, $sql);
    }
}