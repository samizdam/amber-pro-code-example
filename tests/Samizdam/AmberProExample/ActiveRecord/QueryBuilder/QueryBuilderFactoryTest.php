<?php

namespace Samizdam\AmberProExample\ActiveRecord\QueryBuilder;

use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\Exception\UnsupportedDriverException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class QueryBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetQueryBuilder()
    {
        $pdo = new \PDO('sqlite::memory:');
        $queryBuilder = QueryBuilderFactory::getQueryBuilder($pdo);
        $this->assertInstanceOf(BaseQueryBuilder::class, $queryBuilder);
    }

    public function testUnsupportedDriverException()
    {
        $unknownPdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
        $unknownPdoMock->method('getAttribute')->willReturn('unknown');
        $this->expectException(UnsupportedDriverException::class);
        QueryBuilderFactory::getQueryBuilder($unknownPdoMock);
    }
}