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

    /**
     * Check if $path is absolute.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function isAbsolute(string $path): bool
    {
        return strpos($path, DIRECTORY_SEPARATOR) === 0;
    }

    /**
     * Check if $path is relative.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function isRelative(string $path): bool
    {
        return strpos($path, '.' . DIRECTORY_SEPARATOR) === 0 ||
               strpos($path, '..' . DIRECTORY_SEPARATOR) === 0;
    }
}
