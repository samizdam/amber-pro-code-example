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

    public function buildSelectAllQuery(string $tableName, array $whereColumns): string
    {
        $selectPattern = 'SELECT * FROM `%s` WHERE 1 %s';
        $wherePart = array_reduce($whereColumns, function ($sql, $columnName) {
            $sql .= 'AND `' . $columnName . '` = :' . $columnName;
            return $sql;
        });
        $selectSql = sprintf($selectPattern, $tableName, $wherePart);
        return $selectSql;
    }

    public function buildUpdateQuery(string $tableName, array $setColumns, array $whereColumns): string
    {
        $updatePattern = 'UPDATE `%s` SET %s WHERE 1 %s';
        $setPart = array_reduce($setColumns, function($sql, $columnName){
            if($sql == '') {
                $sql .= '`' . $columnName . '` = :' . $columnName;
            } else {
                $sql .= ', `' . $columnName . '` = :' . $columnName;
            }
            return $sql;
        });
        $wherePart = array_reduce($whereColumns, function ($sql, $columnName) {
            $sql .= 'AND `' . $columnName . '` = :' . $columnName;
            return $sql;
        });
        $updateSql = sprintf($updatePattern, $tableName, $setPart, $wherePart);
        return $updateSql;
    }
}