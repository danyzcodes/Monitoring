<?php

namespace App\Helpers;

class MaskedRow
{
    /**
     * Fallback for undefined properties to match Eloquent's behavior,
     * returning null instead of throwing an ErrorException.
     */
    public function __get($name)
    {
        return null;
    }
}
