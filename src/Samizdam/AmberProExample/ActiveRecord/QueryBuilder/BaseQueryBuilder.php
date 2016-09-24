<?php

namespace Samizdam\AmberProExample\ActiveRecord\QueryBuilder;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseQueryBuilder implements QueryBuilderInterface
{

    public function buildInsertQuery(string $tableName, array $columnsNames): string
    {
        $insertPattern = 'INSERT INTO `%s` (%s) VALUES (%s)';
        $columnsPart = array_reduce($columnsNames, function ($sql, $columnName) {
            if ($sql != '') {
                $sql .= ', `' . $columnName . '`';
            } else {
                $sql .= '`' . $columnName . '`';
            }

            return $sql;
        });
        $valuesPart = array_reduce($columnsNames, function ($sql, $columnName) {
            if ($sql != '') {
                $sql .= ', :' . $columnName;
            } else {
                $sql .= ':' . $columnName;
            }
            return $sql;
        });
        $insertSqlString = sprintf($insertPattern, $tableName, $columnsPart, $valuesPart);
        return $insertSqlString;
    }
}