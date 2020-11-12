<?php

namespace AntonioKadid\WAPPKitCore\Localization;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class StringCollector.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class StringCollector
{
    /** @var string */
    private $regex = "/%s\\(\s*(([\"\'])(?:[^\\2\\\\]|\\\\.)*?\\2)(\s*\\)|\\,[^\\)]+\\))/";
    /** @var string */
    private $srcDirectory;

    /**
     * StringCollector constructor.
     *
     * @param string $srcDirectory
     * @param string $functionName
     */
    public function __construct(string $srcDirectory, string $functionName = '__')
    {
        $this->srcDirectory    = $srcDirectory;
        $this->regex           = sprintf($this->regex, $functionName);
    }

    /**
     * Collect strings from all PHP files found recursivelly in source directory.
     *
     * @return array
     */
    public function collect(): array
    {
        if (!is_readable($this->srcDirectory)) {
            return [];
        }

        $filesIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->srcDirectory));

        $result = [];

        // @var SplFileInfo $file
        foreach ($filesIterator as $file) {
            if ($file->isDir() || strcasecmp($file->getExtension(), 'php') !== 0) {
                continue;
            }

            $strings = $this->processPHPFile($file, $result);

            $result = array_merge($result, $strings);
        }

        return $result;
    }

    /**
     * Extract strings from a PHP file used as parameters of the provided function name.
     *
     * @param SplFileInfo $file
     *
     * @return array
     */
    private function processPHPFile(SplFileInfo $file): array
    {
        $path = realpath($file->getPathname());

        $contents = file_get_contents($path);

        $count = preg_match_all($this->regex, $contents, $matches);
        if ($count === false || $count == 0) {
            return [];
        }

        array_walk($matches[1], function (string &$match) {
            $match = trim($match, '\'"');
        });

        return $matches[1];
    }
}
