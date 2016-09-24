<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface FinderInterface
{

    public function getRecordById($id): ActiveRecordInterface;
}