<?php

namespace AntonioKadid\WAPPKitCore\IO;

use DirectoryIterator;
use SplFileInfo;

/**
 * Class File.
 *
 * @package AntonioKadid\WAPPKitCore\IO
 */
class File
{
    /**
     * Attempt to delete a file. If it is a directory attempt to delete it recursively.
     *
     * @param SplFileInfo $file
     */
    public static function delete(SplFileInfo $file)
    {
        $pathname = $file->getPathname();

        if (!$file->isDir()) {
            if (!file_exists($pathname)) {
                return;
            }

            unlink($pathname);
            return;
        }

        $files = new DirectoryIterator($pathname);
        foreach ($files as $file) {
            if ($file->isDot()) {
                continue;
            }

            self::delete($file);
        }

        if (!file_exists($pathname)) {
            return;
        }

        rmdir($pathname);
    }
}
