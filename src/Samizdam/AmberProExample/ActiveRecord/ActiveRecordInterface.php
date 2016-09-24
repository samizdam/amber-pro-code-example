<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ActiveRecordInterface
{

    public static function getTableName(): string;

    public function isPersisted(): bool;

    public function delete();

    public function save();

    public static function getFinder(\PDO $pdoConnection): FinderInterface;

    public function getConnection(): \PDO;
}