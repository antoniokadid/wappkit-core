<?php

namespace AntonioKadid\WAPPKitCore\Modules;

use AntonioKadid\WAPPKitCore\Exceptions\DevelopmentException;
use AntonioKadid\WAPPKitCore\Exceptions\SettingsException;
use AntonioKadid\WAPPKitCore\Settings;
use AntonioKadid\WAPPKitCore\Text\Exceptions\DecodingException;
use AntonioKadid\WAPPKitCore\Text\JSON\JSONDecoder;

/**
 * Class Module
 *
 * @package AntonioKadid\WAPPKitCore\Modules
 */
class Module
{
    const SETTINGS_MODULES_ROOT_PATH = 'ModulesRootPath';
    const MODULE_FILENAME = 'modules.json';

    /**
     * Module constructor
     */
    public function __construct()
    {
    }

    /** @var string */
    public $identifier;
    /** @var string */
    public $name;
    /** @var float */
    public $version;
    /** @var array */
    public $dependencies = [];

    /**
     * Get the list of the available module information.
     *
     * @param Settings $settings
     *
     * @return array
     * @throws SettingsException
     * @throws DevelopmentException
     * @throws DecodingException
     */
    public static function all(Settings $settings): array
    {
        $settings->throwIfNotInitialized();

        $modulesRootPath = $settings->getString(self::SETTINGS_MODULES_ROOT_PATH);
        if ($modulesRootPath == NULL)
            throw new DevelopmentException('The modules root path is not defined in settings.');

        if (!file_exists($modulesRootPath))
            throw new DevelopmentException('The modules root path does not exist.');

        $moduleNames = scandir($modulesRootPath);
        if ($moduleNames === FALSE)
            throw new DevelopmentException('Unable to retrieve the list of directories under modules root path.');

        $moduleNames = array_diff($moduleNames, ['.', '..']);

        $modules = [];
        foreach ($moduleNames as $moduleName) {
            $module = self::findByName($settings, $moduleName);
            if ($module == NULL)
                continue;

            $modules[] = $module;
        }

        return $modules;
    }

    /**
     * Get module information given its name.
     *
     * @param Settings $settings
     * @param string   $moduleName
     *
     * @return Module|null
     * @throws DecodingException
     * @throws SettingsException
     * @throws DevelopmentException
     */
    public static function findByName(Settings $settings, string $moduleName): ?Module
    {
        $settings->throwIfNotInitialized();

        $modulesRootPath = $settings->getString(self::SETTINGS_MODULES_ROOT_PATH);
        if ($modulesRootPath == NULL)
            throw new DevelopmentException('The modules root path is not defined in settings.');

        $path = implode(DIRECTORY_SEPARATOR, [$modulesRootPath, $moduleName, self::MODULE_FILENAME]);
        if (!file_exists($path) || !is_readable($path))
            return NULL;

        $module = new Module();
        $module->loadFromFile($path);

        return $module;
    }

    /**
     * @param string $filepath
     *
     * @return $this
     * @throws DecodingException
     * @throws DevelopmentException
     */
    public function loadFromFile(string $filepath): Module
    {
        if (!file_exists($filepath) || !is_readable($filepath))
            throw new DevelopmentException('Unable to load module info.');

        $this->loadFromJson(file_get_contents($filepath));

        return $this;
    }

    /**
     * @param string $json
     *
     * @return $this
     * @throws DecodingException
     * @throws DevelopmentException
     */
    public function loadFromJson(string $json): Module
    {
        $result = JSONDecoder::default($json);
        if ($result == NULL)
            throw new DevelopmentException('Unable to load module info.');

        $this->identifier = $result['id'];
        $this->name = $result['name'];
        $this->version = floatval($result['version']);
        if (is_array($result['dependencies']))
            $this->dependencies = $result['dependencies'];
        else
            $this->dependencies = [];

        return $this;
    }
}