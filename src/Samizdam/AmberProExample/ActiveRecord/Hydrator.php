<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Hydrator
{

    public function hydrate($hydrable): array
    {
        return get_object_vars($hydrable);
    }
}