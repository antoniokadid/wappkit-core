<?php

namespace AntonioKadid\WAPPKitCore\Extensibility;

/**
 * Class Filter.
 *
 * @package AntonioKadid\WAPPKitCore\Extensibility
 */
class Filter extends Hook
{
    /** @var CallableRegistry */
    private static $registry = null;

    /**
     * Apply a filter.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public static function apply(string $name, $value)
    {
        $section = self::registry()->section($name);
        if ($section == null) {
            return;
        }

        $result = $value;
        foreach ($section as $uniqueId => $callable) {
            $result = call_user_func_array($callable, [$result]);
        }

        return $result;
    }

    /**
     * Get the callable registry.
     *
     * @return CallableRegistry
     */
    protected static function registry(): CallableRegistry
    {
        if (self::$registry == null) {
            self::$registry = new CallableRegistry('filter');
        }

        return self::$registry;
    }
}
