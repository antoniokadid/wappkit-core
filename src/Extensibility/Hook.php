<?php

namespace AntonioKadid\WAPPKitCore\Extensibility;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;

/**
 * Class Hook.
 *
 * @package AntonioKadid\WAPPKitCore\Extensibility
 */
abstract class Hook
{
    /**
     * @param string   $name
     * @param callable $callable
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public static function add(string $name, callable $callable): string
    {
        return static::registry()
            ->add($name, $callable);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function any(string $name): bool
    {
        return static::registry()
            ->any($name);
    }

    /**
     * @param string $uniqueRef
     */
    public static function remove(string $uniqueRef): void
    {
        static::registry()
            ->remove($uniqueRef);
    }

    abstract protected static function registry(): CallableRegistry;
}
