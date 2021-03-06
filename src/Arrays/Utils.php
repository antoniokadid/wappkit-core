<?php

namespace AntonioKadid\WAPPKitCore\Arrays;

/**
 * Class Utils.
 *
 * @package AntonioKadid\WAPPKitCore\Arrays
 */
final class Utils
{
    private function __construct()
    {
    }

    /**
     * Check if all the items of the $array satisfy a condition defined by $predicate.
     *
     * @param array    $array
     * @param callable $predicate
     *
     * @return bool
     */
    public static function all(array $array, callable $predicate): bool
    {
        foreach ($array as $item) {
            if (call_user_func($predicate, $item) !== true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if any of the items of the $array satisfy a condition defined by $predicate.
     *
     * @param array    $array
     * @param callable $predicate
     *
     * @return bool
     */
    public static function any(array $array, callable $predicate): bool
    {
        foreach ($array as $item) {
            if (call_user_func($predicate, $item) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find an item that satisfies the conditions defined by $predicate.
     * Return the default if nothing is found.
     *
     * @param array      $array
     * @param callable   $predicate
     * @param null|mixed $default
     *
     * @return mixed
     */
    public static function find(array $array, callable $predicate, $default = null)
    {
        foreach ($array as $item) {
            if (call_user_func($predicate, $item) === true) {
                return $item;
            }
        }

        return $default;
    }

    /**
     * Group $array based on the keys that are generated by $selectors.
     *
     * @param array $array
     *
     * @return array
     */
    public static function group(array &$array): Group
    {
        return new Group($array);
    }

    /**
     * Returns a specified number of contiguous items from the end of $array.
     *
     * @param array $array
     * @param int   $count
     *
     * @return array
     */
    public static function last(array $array, int $count = 1): array
    {
        if ($count <= 0) {
            return $array;
        }

        return array_values(array_slice($array, -$count, $count));
    }

    /**
     * Returns the maximum projected value using $selector.
     *
     * @param array    $array
     * @param callable $selector
     *
     * @return mixed
     */
    public static function max(array $array, callable $selector)
    {
        if (empty($array)) {
            return false;
        }

        return \max(array_map($selector, $array));
    }

    /**
     * Returns the minimum projected value using $selector.
     *
     * @param array    $array
     * @param callable $selector
     *
     * @return mixed
     */
    public static function min(array $array, callable $selector)
    {
        if (empty($array)) {
            return false;
        }

        return \min(array_map($selector, $array));
    }

    /**
     * Returns a specified number of random items.
     *
     * @param array $array
     * @param int   $count
     *
     * @return array
     */
    public static function random(array $array, int $count = 1): array
    {
        if ($count <= 0) {
            return [];
        }

        if (count($array) <= $count) {
            shuffle($array);

            return $array;
        }

        $keys = array_rand($array, $count);
        $keys = !is_array($keys) ? [$keys] : $keys;

        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * Bypasses a specified number of items returns the remaining items.
     *
     * @param array $array
     * @param int   $count
     *
     * @return array
     */
    public static function skip(array $array, int $count = 1): array
    {
        return array_slice($array, $count);
    }

    /**
     * @param array $array
     *
     * @return Sort
     */
    public static function sort(array &$array): Sort
    {
        return new Sort($array);
    }

    /**
     * Computes the sum of the numeric projected values using $selector.
     *
     * @param array    $array
     * @param callable $selector
     *
     * @return float|int
     */
    public static function sum(array $array, callable $selector)
    {
        return \array_sum(
            array_filter(
                array_map($selector, $array),
                function ($item) {
                    return is_int($item) || is_float($item);
                }
            )
        );
    }

    /**
     * Returns a specified number of contiguous items from the start of $array.
     *
     * @param array $array
     * @param int   $count
     *
     * @return array
     */
    public static function take(array $array, int $count = 1): array
    {
        if ($count <= 0) {
            return $array;
        }

        return array_slice($array, 0, $count);
    }
}
