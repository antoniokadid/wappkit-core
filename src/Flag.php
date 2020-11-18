<?php

namespace AntonioKadid\WAPPKitCore;

/**
 * Class Flag.
 *
 * @package AntonioKadid\WAPPKitCore
 */
class Flag
{
    /**
     * @param int $flags
     * @param int $flag
     *
     * @return bool
     */
    public static function exists(int $flags, int $flag): bool
    {
        return ($flags & $flag) === $flag;
    }
}
