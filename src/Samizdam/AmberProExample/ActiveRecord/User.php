<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class User extends AbstractActiverRecord
{

    public static function getTableName(): string
    {
        return 'user';
    }

    public static function getPrimaryKeyColumns(): array
    {
        return ['id'];
    }
}