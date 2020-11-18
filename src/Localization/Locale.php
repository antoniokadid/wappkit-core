<?php

namespace AntonioKadid\WAPPKitCore\Localization;

/**
 * Class Translation.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
class Locale
{
    /** @var Locale */
    private static $activeLocale = null;

    /** @var string */
    private $locale;

    private function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public static function active(): ?Locale
    {
        return self::$activeLocale;
    }

    /**
     * Set the active locale.
     *
     * @param string $locale
     */
    public static function setActive(string $locale)
    {
        if (self::$activeLocale instanceof Locale) {
            return self::$activeLocale;
        }

        self::$activeLocale =  new Locale($locale);
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
