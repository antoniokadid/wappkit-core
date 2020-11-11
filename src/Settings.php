<?php

namespace AntonioKadid\WAPPKitCore;

use AntonioKadid\WAPPKitCore\Collections\Map;
use AntonioKadid\WAPPKitCore\Exceptions\DevelopmentException;
use AntonioKadid\WAPPKitCore\Exceptions\SettingsException;
use AntonioKadid\WAPPKitCore\Text\JSON\JSONDecoder;

/**
 * Class Settings.
 *
 * @package AntonioKadid\WAPPKitCore
 */
class Settings extends Map
{
    /** @var null|Settings */
    private static $settings = null;

    /** @var bool */
    private $initialized = false;

    /**
     * Settings constructor.
     *
     * @param array $source
     */
    private function __construct(array $source = [])
    {
        parent::__construct($source);
    }

    /**
     * @return Settings
     */
    public static function get(): Settings
    {
        if (self::$settings == null) {
            self::$settings = new Settings();
        }

        return self::$settings;
    }

    /**
     * @return bool
     */
    public function initialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @param string $filepath
     *
     * @throws DevelopmentException
     * @throws Text\Exceptions\DecodingException
     *
     * @return $this
     */
    public function loadFromFile(string $filepath): Settings
    {
        if (!file_exists($filepath) || !is_readable($filepath)) {
            throw new DevelopmentException('Unable to load settings file.');
        }

        return $this->loadFromJson(file_get_contents($filepath));
    }

    /**
     * @param string $json
     *
     * @throws DevelopmentException
     * @throws Text\Exceptions\DecodingException
     *
     * @return $this
     */
    public function loadFromJson(string $json): Settings
    {
        $result = JSONDecoder::default($json);
        if ($result == null) {
            throw new DevelopmentException('Unable to load settings file.');
        }

        $this->source = $result;

        return $this;
    }

    /**
     * @throws SettingsException
     */
    public function throwIfNotInitialized(): void
    {
        if (!$this->initialized()) {
            throw new SettingsException('Settings not initialized.');
        }
    }
}
