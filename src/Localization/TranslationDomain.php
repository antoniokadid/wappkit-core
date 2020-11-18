<?php

namespace AntonioKadid\WAPPKitCore\Localization;

use AntonioKadid\WAPPKitCore\Collections\Map;

class TranslationDomain
{
    /** @var array */
    private static $domainInstance = [];
    /** @var array */
    private static $domainPaths = [];

    /** @var string */
    private $name;
    /** @var string */
    private $path;
    /** @var array */
    private $translations = [];

    /**
     * @param string $name
     * @param string $path
     */
    private function __construct(string $name, string $path)
    {
        $this->name   = $name;
        $this->path   = $path;
    }

    /**
     * @param string $name
     *
     * @return null|TranslationDomain
     */
    public static function get(string $name): ?TranslationDomain
    {
        if (isset(self::$domainInstance[$name])) {
            return self::$domainInstance[$name];
        }

        if (!isset(self::$domainPaths[$name])) {
            return null;
        }

        self::$domainInstance[$name] = new TranslationDomain($name, self::$domainPaths[$name]);

        return self::$domainInstance[$name];
    }

    /**
     * Assosiate a translation domain with a path.
     *
     * @param string $name
     * @param string $path
     *
     * @return bool
     */
    public static function register(string $name, string $path): bool
    {
        if (!is_readable($path)) {
            return false;
        }

        self::$domainPaths[$name] = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get translation map.
     *
     * @return null|Map
     */
    public function getTranslations(string $locale): ?Map
    {
        if (isset($this->translations[$locale]) && $this->translations[$locale] instanceof Map) {
            return $this->translations[$locale];
        }

        $path = $this->path . DIRECTORY_SEPARATOR . $locale . '.json';
        if (!is_readable($this->path)) {
            return null;
        }

        $result = json_decode(file_get_contents($this->path), true);
        if ($result == null || !is_array($result)) {
            return null;
        }

        $this->translations[$locale] = new Map($result);

        return $this->translations[$locale];
    }
}
