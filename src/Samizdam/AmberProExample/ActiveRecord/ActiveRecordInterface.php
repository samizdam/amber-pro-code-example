<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ActiveRecordInterface
{

    public function isPersisted(): bool;

    public function delete();

    public function save();
}