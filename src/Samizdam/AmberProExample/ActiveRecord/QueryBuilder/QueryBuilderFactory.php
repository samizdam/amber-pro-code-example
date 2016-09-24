<?php

namespace Samizdam\AmberProExample\ActiveRecord\QueryBuilder;

use Samizdam\AmberProExample\ActiveRecord\QueryBuilder\Exception\UnsupportedDriverException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class QueryBuilderFactory
{

    const DRIVER_SQLITE = 'sqlite';

    private static $queryBuilderDriverMap = [
        self::DRIVER_SQLITE => BaseQueryBuilder::class,
    ];

    public static function getQueryBuilder(\PDO $connection): QueryBuilderInterface
    {
        $driver = $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
        if (isset(self::$queryBuilderDriverMap[$driver])) {
            $concreteBuilderClass = self::$queryBuilderDriverMap[$driver];
        } else {
            throw new UnsupportedDriverException($driver . ' not supported. ');
        }

        return new $concreteBuilderClass;

    }

}