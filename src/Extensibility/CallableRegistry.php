<?php

namespace AntonioKadid\WAPPKitCore\Extensibility;

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
        if (!array_key_exists($name, $this->registry)) {
            $this->registry[$name] = [];
        }

        $uniqueId = uniqid("{$this->name}.{$name}", true);

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
        if (!array_key_exists($name, $this->registry)) {
            return false;
        }

        return count($this->registry[$name]) > 0;
    }

    /**
     * Remove a callable from the registry.
     *
     * @param string $name     the name of the section
     * @param string $uniqueId the unique identifier that was generated when the callable was added to the registry
     */
    public function remove(string $name, string $uniqueId): void
    {
        if (!array_key_exists($name, $this->registry)) {
            return;
        }

        if (!array_key_exists($uniqueId, $this->registry[$name])) {
            return;
        }

        unset($this->registry[$name][$uniqueId]);
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
        if (!array_key_exists($name, $this->registry)) {
            return null;
        }

        return $this->registry[$name];
    }
}
