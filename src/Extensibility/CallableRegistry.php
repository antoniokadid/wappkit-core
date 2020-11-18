<?php

namespace AntonioKadid\WAPPKitCore\Extensibility;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;

use function AntonioKadid\WAPPKitCore\Localization\__;

/**
 * Class CallableRegistry.
 *
 * @package AntonioKadid\WAPPKitCore\Extensibility
 */
class CallableRegistry
{
    /** @var string */
    private $name;
    /** @var array */
    private $registry = [];

    /**
     * CallableRegistry constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (!$this->validName($name)) {
            throw new InvalidArgumentException('name', __('Name can include only a-z, A-Z, 0-9, _ (underscore) and - (dash).', 'wappkit-core'));
        }

        $this->name = $name;
    }

    /**
     * Add a callable to the registry.
     *
     * @param string   $name     the name of the registry section
     * @param callable $callable the callable
     *
     * @return string the unique reference to the added callable
     */
    public function add(string $name, callable $callable): string
    {
        if (!$this->validName($name)) {
            throw new InvalidArgumentException('name', __('Name can include only a-z, A-Z, 0-9, _ (underscore) and - (dash).', 'wappkit-core'));
        }

        if (!isset($this->registry[$name])) {
            $this->registry[$name] = [];
        }

        $uniqueId = uniqid("{$this->name}:{$name}#", true);

        $this->registry[$name][$uniqueId] = $callable;

        return $uniqueId;
    }

    /**
     * Check if there are any callables available for a section.
     *
     * @param string $name the name of the section
     *
     * @return bool
     */
    public function any(string $name): bool
    {
        return isset($this->registry[$name]) && count($this->registry[$name]) > 0;
    }

    /**
     * Remove a callable from the registry.
     *
     * @param string $uniqueRef the unique reference that was generated when the callable was added to the registry
     */
    public function remove(string $uniqueRef): void
    {
        if (preg_match('/^([^:]+):([^#]+)#(.+)$/', $uniqueRef, $uniqueRefData) !== 1) {
            return;
        }

        $registryName = $uniqueRefData[1];
        $section      = $uniqueRefData[2];
        $uniqueId     = $uniqueRefData[3];

        if (strcasecmp($registryName, $this->name) !== 0) {
            return;
        }

        if (!isset($this->registry[$section]) || !isset($this->registry[$section][$uniqueRef])) {
            return;
        }

        unset($this->registry[$section][$uniqueRef]);
    }

    /**
     * Get a section from the registry.
     *
     * @param string $name the name of the section
     *
     * @return null|array
     */
    public function section(string $name): ?array
    {
        if (!$this->validName($name) || !isset($this->registry[$name])) {
            return null;
        }

        return $this->registry[$name];
    }

    /**
     * Validate name.
     *
     * @param string $name
     * @param bool   $silent
     *
     * @return bool
     */
    private function validName(string $name): bool
    {
        return preg_match('/^[\w-]+$/', $name) === 1;
    }
}
