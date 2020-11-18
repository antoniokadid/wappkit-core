<?php

namespace AntonioKadid\WAPPKitCore\Localization;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class StringCollector.
 *
 * @package AntonioKadid\WAPPKitCore\Localization\Translation
 */
class StringCollector
{
    /** @var array */
    private $accumulatedStrings;
    /** @var string */
    private $regex;

    /**
     * StringCollector constructor.
     *
     * @param string $srcDirectory
     * @param string $functionName
     */
    public function __construct(string $functionName = '__')
    {
        $collectSingle = '(?:\s*[\']((?:[^\'\\\\]|\\\\.)*)[\']\s*)';
        $collectDouble = '(?:\s*["]((?:[^"\\\\]|\\\\.)*)["]\s*)';

        $regExWithoutDomain = sprintf('%1$s\((?:%2$s|%3$s)\)', $functionName, $collectSingle, $collectDouble);
        $regExWithDomain    = sprintf('%1$s\((?:%2$s|%3$s),(?:%2$s|%3$s)\)', $functionName, $collectSingle, $collectDouble);

        $this->regex = sprintf('/(?:%s)|(?:%s)/', $regExWithoutDomain, $regExWithDomain);
    }

    /**
     * @param array $directories
     *
     * @throws IOException
     *
     * @return array
     */
    public function collectFromDirectories(array $directories): array
    {
        $this->reset();

        foreach ($directories as $directory) {
            if (!is_readable($directory)) {
                throw new IOException(sprintf(__('%s is not readable.', 'wappkit-core'), $directory));
            }

            $filesIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            // @var SplFileInfo $file
            foreach ($filesIterator as $file) {
                if ($file->isDir() || strcasecmp($file->getExtension(), 'php') !== 0) {
                    continue;
                }

                $this->processFile($file);
            }
        }

        return $this->accumulatedStrings;
    }

    /**
     * @param string $directory
     *
     * @throws IOException
     *
     * @return array
     */
    public function collectFromDirectory(string $directory): array
    {
        return $this->collectFromDirectories([$directory]);
    }

    /**
     * @param string $input
     *
     * @return array
     */
    public function collectFromString(string $input): array
    {
        $this->reset();
        $this->processString($input);

        return $this->accumulatedStrings;
    }

    /**
     * Extract strings from a PHP file used as parameters of the provided function name.
     *
     * @param SplFileInfo $file
     */
    private function processFile(SplFileInfo $file): void
    {
        $path = realpath($file->getPathname());

        if (!is_readable($path)) {
            return;
        }

        $this->processString(file_get_contents($path));
    }

    /**
     * @param array $noDomainStrings
     * @param array $domainStrings
     * @param array $domains
     */
    private function processMatches(array $noDomainStrings, array $domainStrings, array $domains): void
    {
        $count = max(count($noDomainStrings), count($domainStrings), count($domains));

        for ($i = 0; $i < $count; $i++) {
            $string = empty($domains[$i]) ? $noDomainStrings[$i] : $domainStrings[$i];
            $domain = empty($domains[$i]) ? DEFAULT_DOMAIN : $domains[$i];

            if (!isset($this->accumulatedStrings[$domain])) {
                $this->accumulatedStrings[$domain] = [];
            }

            array_push($this->accumulatedStrings[$domain], $string);
        }
    }

    /**
     * Extract strings from a code string used as parameters of the provided function name.
     *
     * @param string $input
     */
    private function processString(string $input): void
    {
        $count = preg_match_all($this->regex, $input, $matches);
        if ($count === false || $count == 0) {
            return;
        }

        $this->processMatches($matches[1], $matches[3], $matches[5]);
    }

    private function reset(): void
    {
        unset($this->accumulatedStrings);

        $this->accumulatedStrings = [];
    }
}
