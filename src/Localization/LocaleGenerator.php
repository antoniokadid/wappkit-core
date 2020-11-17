<?php

namespace AntonioKadid\WAPPKitCore\Localization;

/**
 * Class LocaleGenerator.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class LocaleGenerator
{
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
    public function __construct(string $outputDirectory, array $locales = [], array $strings = [], bool $clean = false)
    {
        $this->outputDirectory = $outputDirectory;
        $this->locales         = $locales;
        $this->strings         = $strings;
        $this->clean           = $clean;
    }

    public function generate()
    {
        $uniqueStrings = array_unique($this->strings);

        foreach ($this->locales as $locale) {
            self::processStringsForLocale($this->outputDirectory, $uniqueStrings, $locale, $this->clean);
        }
    }

    /**
     * Remove existing strings that do not exist in collected strings.
     *
     * @param array $existingStrings
     * @param array $collectedStrings
     *
     * @return array
     */
    private static function cleanExistingStrings(array $existingStrings, array $collectedStrings)
    {
        return array_filter(
            $existingStrings,
            function ($item, $key) use ($collectedStrings) {
                return in_array($key, $collectedStrings);
            },
            ARRAY_FILTER_USE_BOTH
        );
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
    private static function processStringsForLocale(string $outputDirectory, array $strings, string $locale, bool $clean)
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

            if ($clean === true) {
                $existingStringsCleaned = self::cleanExistingStrings($existingStrings, $strings);

                if (count($existingStrings) !== count($existingStringsCleaned)) {
                    $existingStrings = $existingStringsCleaned;
                    $updated = true;
                }
            }

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
