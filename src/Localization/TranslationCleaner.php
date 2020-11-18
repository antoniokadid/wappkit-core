<?php

namespace AntonioKadid\WAPPKitCore\Localization;

use AntonioKadid\WAPPKitCore\IO\File;
use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class TranslationCleaner.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class TranslationCleaner
{
    /** @var string */
    private $directory;

    /**
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    /**
     * Remove domains not present in $skipDomains.
     *
     * @param array $skipDomains
     */
    public function cleanDomains(array $skipDomains = [])
    {
        if (!is_readable($this->directory)) {
            return;
        }

        $iterator = new DirectoryIterator($this->directory);
        foreach ($iterator as $file) {
            if (!$file->isDir() || $file->isDot() || in_array($file->getFilename(), $skipDomains)) {
                continue;
            }

            File::delete($file);
        }
    }

    /**
     * Delete locales not present in $skipLocales.
     *
     * @param array $skipLocales
     */
    public function cleanLocales(array $skipLocales)
    {
        if (!is_readable($this->directory)) {
            return;
        }

        $filesIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory));

        foreach ($filesIterator as $file) {
            if ($file->isDir() || strcasecmp($file->getExtension(), 'json') !== 0) {
                continue;
            }

            if (in_array($file->getBasename(".{$file->getExtension()}"), $skipLocales)) {
                continue;
            }

            File::delete($file);
        }
    }

    /**
     * Check if any translation is not included in $newTranslations and remove it.
     *
     * @param string $domain
     * @param string $locale
     * @param array  $newStrings
     *
     * @return bool
     */
    public function cleanStrings(string $domain, string $locale, array $newStrings): bool
    {
        $jsonFile = $this->directory . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . "{$locale}.json";

        if (!file_exists($jsonFile) || !is_writable($jsonFile)) {
            return false;
        }

        $existingStrings = json_decode(file_get_contents($jsonFile), true);
        if ($existingStrings == null) {
            return false;
        }

        $cleaned = array_filter(
            $existingStrings,
            function ($item, $key) use ($newStrings) {
                return in_array($key, $newStrings);
            },
            ARRAY_FILTER_USE_BOTH
        );

        $content = json_encode($cleaned, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($content === false) {
            return false;
        }

        $result = file_put_contents($jsonFile, $content);

        return $result !== false && $result > 0;
    }
}
