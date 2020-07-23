<?php

namespace AntonioKadid\WAPPKitCore;

use AntonioKadid\WAPPKitCore\Collections\Map;
use AntonioKadid\WAPPKitCore\Exceptions\DevelopmentException;
use AntonioKadid\WAPPKitCore\Exceptions\SettingsException;
use AntonioKadid\WAPPKitCore\Text\JSON\JSONDecoder;

/**
 * Class Settings
 *
 * @package AntonioKadid\WAPPKitCore
 */
class Settings extends Map
{
    /** @var Settings|NULL */
    private static $_settings = NULL;

    /** @var bool */
    private $_initialized = FALSE;

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
    public static function Get(): Settings
    {
        if (self::$_settings == NULL)
            self::$_settings = new Settings();

        return self::$_settings;
    }

    /**
     * @return bool
     */
    public function initialized(): bool
    {
        return $this->_initialized;
    }

    /**
     * @throws SettingsException
     */
    public function throwIfNotInitialized(): void
    {
        if (!$this->initialized())
            throw new SettingsException('Settings not initialized.');
    }

    /**
     * @param string $filepath
     *
     * @return $this
     * @throws DevelopmentException
     * @throws Text\Exceptions\DecodingException
     */
    public function loadFromFile(string $filepath): Settings
    {
        if (!file_exists($filepath) || !is_readable($filepath))
            throw new DevelopmentException('Unable to load settings file.');

        return $this->loadFromJson(file_get_contents($filepath));
    }


    /**
     * @param string $json
     *
     * @return $this
     * @throws DevelopmentException
     * @throws Text\Exceptions\DecodingException
     */
    public function loadFromJson(string $json): Settings
    {
        $result = JSONDecoder::default($json);
        if ($result == NULL)
            throw new DevelopmentException('Unable to load settings file.');

        $this->source = $result;

        return $this;
    }
}