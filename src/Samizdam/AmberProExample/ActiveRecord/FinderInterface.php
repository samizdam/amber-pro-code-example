<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface FinderInterface
{

    /**
     * Get AR instance with optional custom PDO connection.
     */
    public function getRecordByPK($pkValue, \PDO $recordInstansPdoConnection = null): ActiveRecordInterface;
}