<?php

namespace AntonioKadid\WAPPKitCore\Arrays;

use AntonioKadid\WAPPKitCore\Data\Value;
use ArrayAccess;

/**
 * Class Offset.
 * Access an array offset even if it does not exist.
 *
 * @package AntonioKadid\WAPPKitCore\Arrays
 */
class Offset implements ArrayAccess
{
    /** @var array */
    private $array;

    /**
     * @param array $array
     */
    public function __construct(array &$array)
    {
        $this->array = &$array;
    }

    /**
     * @param array $array
     * @param mixed $offset
     *
     * @return bool
     */
    public static function exists(array $array, $offset): bool
    {
        return self::recursiveOffsetExists($array, self::processOffset($offset));
    }

    /**
     * @param array $array
     * @param mixed $offset
     *
     * @return Value
     */
    public static function get(array $array, $offset): Value
    {
        return new Value(
            self::recursiveOffsetGet($array, self::processOffset($offset))
        );
    }

    /**
     * @param array $array
     * @param mixed $offset
     * @param mixed $value
     */
    public static function set(array &$array, $offset, $value): void
    {
        self::recursiveOffsetSet($array, self::processOffset($offset), $value);
    }

    /**
     * @param array $array
     * @param mixed $offset
     */
    public static function unset(array &$array, $offset): void
    {
        self::recursiveOffsetUnset($array, self::processOffset($offset));
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return self::exists($this->array, $offset);
    }

    /**
     * @param mixed $offset
     *
     * @return Value
     */
    public function offsetGet($offset)
    {
        return self::get($this->array, $offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        self::set($this->array, $offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        self::unset($this->array, $offset);
    }

    /**
     * @param mixed $offset
     *
     * @return array
     */
    private static function processOffset($offset): array
    {
        if (!is_string($offset)) {
            return [$offset];
        }
        $offsets = preg_split('/(?<!\\\\)\//', $offset, -1, PREG_SPLIT_NO_EMPTY);
        if ($offsets === false) {
            return [$offset];
        }

        return $offsets;
    }

    /**
     * @param array $array
     * @param array $offsets
     *
     * @return bool
     */
    private static function recursiveOffsetExists(array $array, array $offsets): bool
    {
        if (empty($offsets)) {
            return false;
        }

        $currentOffset = array_shift($offsets);
        if ($currentOffset == null) {
            return false;
        }

        if (empty($offsets)) {
            // the last offset
            return array_key_exists($currentOffset, $array);
        }

        if (!array_key_exists($currentOffset, $array) || !is_array($array[$currentOffset])) {
            return false;
        }

        return self::recursiveOffsetExists($array[$currentOffset], $offsets);
    }

    /**
     * @param array $array
     * @param array $offsets
     *
     * @return mixed
     */
    private static function recursiveOffsetGet(array $array, array $offsets)
    {
        $currentOffset = array_shift($offsets);
        if ($currentOffset == null) {
            return null;
        }

        if (empty($offsets)) {
            // the last offset
            return array_key_exists($currentOffset, $array) ? $array[$currentOffset] : null;
        }

        if (!array_key_exists($currentOffset, $array) || !is_array($array[$currentOffset])) {
            return null;
        }

        return self::recursiveOffsetGet($array[$currentOffset], $offsets);
    }

    /**
     * @param array $array
     * @param array $offsets
     * @param mixed $value
     *
     * @return mixed
     */
    private static function recursiveOffsetSet(array &$array, array $offsets, $value)
    {
        $currentOffset = array_shift($offsets);
        if ($currentOffset == null) {
            return;
        }

        if (empty($offsets)) {
            // the last offset
            $array[$currentOffset] = $value;
            return;
        }

        if (!array_key_exists($currentOffset, $array)) {
            $array[$currentOffset] = [];
        } elseif (!is_array($array[$currentOffset])) {
            $array[$currentOffset] = [$array[$currentOffset]];
        }

        return self::recursiveOffsetSet($array[$currentOffset], $offsets, $value);
    }

    /**
     * @param array $array
     * @param array $offsets
     *
     * @return mixed
     */
    private static function recursiveOffsetUnset(array &$array, array $offsets)
    {
        $currentOffset = array_shift($offsets);
        if ($currentOffset == null) {
            return;
        }

        if (empty($offsets)) {
            // the last offset
            if (array_key_exists($currentOffset, $array)) {
                unset($array[$currentOffset]);
            }

            return;
        }

        if (!array_key_exists($currentOffset, $array) || !is_array($array[$currentOffset])) {
            return;
        }

        return self::recursiveOffsetUnset($array[$currentOffset], $offsets);
    }
}
