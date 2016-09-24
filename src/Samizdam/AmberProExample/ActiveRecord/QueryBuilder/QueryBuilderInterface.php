<?php

namespace Samizdam\AmberProExample\ActiveRecord\QueryBuilder;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface QueryBuilderInterface
{

    public function buildInsertQuery(string $tableName, array $columns): string;

    public function buildSelectAllQuery(string $tableName, array $whereColumns): string;
}