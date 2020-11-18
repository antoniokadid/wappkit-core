<?php

namespace AntonioKadid\WAPPKitCore\Localization;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;
use AntonioKadid\WAPPKitCore\Flag;

/**
 * Class LocaleGenerator.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class TranslationGenerator
{
    public const FLAG_CLEAN_DOMAINS = 4;
    public const FLAG_CLEAN_LOCALES = 2;
    public const FLAG_CLEAN_STRINGS = 1;

    /** @var bool */
    private $clean;
    /** @var string[] */
    private $locales;
    /** @var string */
    private $outputDirectory;
    /** @var string[] */
    private $strings;

    /**
     * LocaleGenerator constructor.
     *
     * @param string[] $locales
     * @param string[] $strings
     */
    public function __construct(string $outputDirectory, array $locales = [], array $strings = [], int $clean = 0)
    {
        $this->outputDirectory = $outputDirectory;
        $this->locales         = $locales;
        $this->strings         = $strings;
        $this->clean           = $clean;
    }

    public function generate()
    {
        $domains = array_keys($this->strings);
        $cleaner = new TranslationCleaner($this->outputDirectory);

        if (Flag::exists($this->clean, self::FLAG_CLEAN_DOMAINS)) {
            $cleaner->cleanDomains($domains);
        }

        if (Flag::exists($this->clean, self::FLAG_CLEAN_LOCALES)) {
            $cleaner->cleanLocales($this->locales);
        }

        foreach ($domains as $domain) {
            if (!self::validDomainName($domain)) {
                throw new IOException(sprintf('Invalid domain name %s', $domain));
            }

            $uniqueStrings = array_unique((array)$this->strings[$domain]);

            foreach ($this->locales as $locale) {
                if (Flag::exists($this->clean, self::FLAG_CLEAN_STRINGS)) {
                    $cleaner->cleanStrings($domain, $locale, $uniqueStrings);
                }

                self::processStringsForLocale($this->outputDirectory . DIRECTORY_SEPARATOR . $domain, $locale, $uniqueStrings);
            }
        }
    }

    /**
     * Validate domain name.
     *
     * @param string $name
     *
     * @return bool
     */
    private static function validDomainName(string $name): bool
    {
        return preg_match('/^[\w-]+$/', $name) === 1;
    }

    /**
     * Save the strings into a JSON locale file.
     *
     * @param string $outputDirectory
     * @param array  $strings
     * @param string $locale
     *
     * @return bool|int
     */
    private static function processStringsForLocale(string $outputDirectory, string $locale, array $strings)
    {
        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0777, true);
        }

        $filename = "{$outputDirectory}/{$locale}.json";
        $content  = '';

        if (file_exists($filename) && ($existingStrings = json_decode(file_get_contents($filename), true)) !== false) {
            foreach ($strings as $string) {
                if (array_key_exists($string, $existingStrings)) {
                    continue;
                }

                $existingStrings[$string] = '';
            }

            $content = json_encode($existingStrings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $values        = array_fill(0, count($strings), '');
            $keyValuePairs = array_combine($strings, $values);

            $content = json_encode($keyValuePairs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $result = file_put_contents($filename, $content);

        return $result !== false && $result > 0;
    }
}
