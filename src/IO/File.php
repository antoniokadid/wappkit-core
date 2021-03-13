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

    /**
     * Get the maximum size for file upload.
     * https://stackoverflow.com/questions/2840755/how-to-determine-the-max-file-upload-limit-in-php.
     *
     * @return int
     */
    public static function maxUploadSize(): int
    {
        //select maximum upload size
        $maxUpload = self::getBytesFromIniValue(ini_get('upload_max_filesize'));
        //select post limit
        $maxPost = self::getBytesFromIniValue(ini_get('post_max_size'));
        //select memory limit
        $memoryLimit = self::getBytesFromIniValue(ini_get('memory_limit'));
        // return the smallest of them, this defines the real limit
        return min($maxUpload, $maxPost, $memoryLimit);
    }

    /**
     * @param string $val
     *
     * @return int
     */
    private static function getBytesFromIniValue(string $val): int
    {
        $matches = [];
        if (!preg_match('/\s*(\d+)([[:alpha:]])?\s*/', $val, $matches)) {
            return 0;
        }

        $size     = intval($matches[1]);
        $modifier = isset($matches[2]) ? strtolower($matches[2]) : '';

        switch ($modifier) {
            case 'g':
                $size *= 1024;
                // no break
            case 'm':
                $size *= 1024;
                // no break
            case 'k':
                $size *= 1024;
        }

        return $size;
    }
}
