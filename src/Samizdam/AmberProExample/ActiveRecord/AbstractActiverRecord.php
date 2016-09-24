<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractActiverRecord implements ActiveRecordInterface
{

    /**
     * @var \PDO
     */
    private $pdoConnection;
    private $isPersisted = false;

    public function __construct(\PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public static function populate(\PDO $pdoConnection, array $fields)
    {
        $record = new static($pdoConnection);
        foreach ($fields as $fieldName => $value) {
            $record->$fieldName = $value;
        }
        $record->isPersisted = true;
        return $record;
    }

    public function getConnection(): \PDO
    {
        return $this->pdoConnection;
    }

    public function isPersisted(): bool
    {
        return $this->isPersisted;
    }
}