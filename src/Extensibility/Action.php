<?php

namespace AntonioKadid\WAPPKitCore\Extensibility;

/**
 * Class Action.
 *
 * @package AntonioKadid\WAPPKitCore\Extensibility
 */
class Action
{
    /** @var CallableRegistry */
    private static $registry = null;

    /**
     * Call an action.
     *
     * @param string  $name
     * @param mixed[] ...$args
     */
    public static function do(string $name, ...$args): void
    {
        $section = self::registry()->section($name);
        if ($section == null) {
            return;
        }

        foreach ($section as $uniqueId => $callable) {
            call_user_func_array($callable, $args);
        }
    }

    /**
     * Get the callable registry.
     *
     * @return CallableRegistry
     */
    public static function registry(): CallableRegistry
    {
        if (self::$registry == null) {
            self::$registry = new CallableRegistry('action');
        }

        return self::$registry;
    }
}
