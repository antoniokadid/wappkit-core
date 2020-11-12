<?php

namespace AntonioKadid\WAPPKitCore\Localization;

/**
 * Class LocaleGenerator.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class LocaleGenerator
{
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
    public function __construct(string $outputDirectory, array $locales = [], array $strings = [])
    {
        $this->outputDirectory = $outputDirectory;
        $this->locales         = $locales;
        $this->strings         = $strings;
    }

    public function generate()
    {
        $uniqueStrings = array_unique($this->strings);

        foreach ($this->locales as $locale) {
            self::processStringsForLocale($this->outputDirectory, $uniqueStrings, $locale);
        }
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
    private static function processStringsForLocale(string $outputDirectory, array $strings, string $locale)
    {
        $filename = "{$outputDirectory}/{$locale}.json";
        $content  = '';

        if (!file_exists($filename)) {
            $values        = array_fill(0, count($strings), '');
            $keyValuePairs = array_combine($strings, $values);

            $content = json_encode($keyValuePairs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $existingStrings = json_decode(file_get_contents($filename), true);

            $updated = false;
            foreach ($strings as $string) {
                if (array_key_exists($string, $existingStrings)) {
                    continue;
                }

                $existingStrings[$string] = '';
                $updated                  = true;
            }

            if (!$updated) {
                return 0;
            }

            $content = json_encode($existingStrings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return file_put_contents($filename, $content);
    }
}
