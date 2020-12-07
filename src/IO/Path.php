<?php

namespace AntonioKadid\WAPPKitCore\IO;

/**
 * Class Path.
 *
 * @package AntonioKadid\WAPPKitCore\IO
 */
class Path
{
    /**
     * Combines an array of strings into a path.
     *
     * @param string[] $paths
     *
     * @return string
     */
    public static function combine(string ...$paths): string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}
