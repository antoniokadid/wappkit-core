<?php

namespace AntonioKadid\WAPPKitCore\Collections;

use DateTime;

/**
 * Class ArrayListSorter
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class ArrayListSorter
{
    private const FLAG_ORDER_BY_ASC = 1;
    private const FLAG_ORDER_BY_DESC = 2;
    private const FLAG_ORDER_BY_CASE_SENSITIVE = 4;
    private const FLAG_ORDER_BY_CASE_INSENSITIVE = 8;
    private const FLAG_ORDER_BY_NATURAL = 16;

    /** @var array */
    private $source;
    /** @var array */
    private $comparators = [];

    /**
     * ArrayListSorter constructor.
     *
     * Sorting works <i>by the reference to</i> the internal array of ArrayList.
     *
     * @param ArrayList $source
     */
    public function __construct(ArrayList $source)
    {
        $this->source = $source;
    }

    /**
     * @param mixed $item1
     * @param mixed $item2
     * @param array $callbacks
     *
     * @return int
     */
    private static function compare($item1, $item2, array $callbacks): int
    {
        $callbackInfo = array_shift($callbacks);
        if ($callbackInfo == NULL || !is_array($callbackInfo))
            return 0;

        list($callback, $flags) = $callbackInfo;
        if (!is_callable($callback))
            return 0;

        $value1 = call_user_func_array($callback, [$item1]);
        $value2 = call_user_func_array($callback, [$item2]);

        if (is_string($value1) && is_string($value2)) {
            $result = self::compareStrings($value1, $value2, $flags);

            return ($result == 0) ?
                self::compare($item1, $item2, $callbacks) :
                $result;
        }

        if (($value1 instanceof DateTime) && ($value2 instanceof DateTime)) {
            if ($value1 == $value2)
                return self::compare($item1, $item2, $callbacks);

            if (self::hasFlag($flags, self::FLAG_ORDER_BY_DESC))
                return $value1 < $value2 ? 1 : -1;
            else
                return $value1 < $value2 ? -1 : 1;
        }

        if (!is_nan($value1) && !is_nan($value2)) {
            if ($value1 == $value2)
                return self::compare($item1, $item2, $callbacks);

            if (self::hasFlag($flags, self::FLAG_ORDER_BY_DESC))
                return $value1 < $value2 ? 1 : -1;
            else
                return $value1 < $value2 ? -1 : 1;
        }

        $result = $value1 <=> $value2;
        if ($result == 0)
            return self::compare($item1, $item2, $callbacks);

        if (self::hasFlag($flags, self::FLAG_ORDER_BY_DESC))
            return $result === -1 ? 1 : -1;
        else
            return $result === -1 ? -1 : 1;
    }

    /**
     * @param string $value1
     * @param string $value2
     * @param int    $flags
     *
     * @return int
     */
    private static function compareStrings(string $value1, string $value2, int $flags): int
    {
        if (self::hasFlag($flags, self::FLAG_ORDER_BY_CASE_INSENSITIVE)) {
            $result = (self::hasFlag($flags, self::FLAG_ORDER_BY_NATURAL)) ?
                strnatcasecmp($value1, $value2) :
                strcasecmp($value1, $value2);
        } else {
            $result = (self::hasFlag($flags, self::FLAG_ORDER_BY_NATURAL)) ?
                strnatcmp($value1, $value2) :
                strcmp($value1, $value2);
        }

        if ($result == 0)
            return $result;

        // Invert result if descending flag is available.
        if (self::hasFlag($flags, self::FLAG_ORDER_BY_DESC))
            return $result < 0 ? 1 : -1;

        return $result;
    }

    /**
     * Check if flag is valid against flags.
     *
     * @param int $flags
     * @param int $flag
     *
     * @return bool
     */
    private static function hasFlag(int $flags, int $flag): bool
    {
        return ($flags & $flag) === $flag;
    }

    /**
     * Defines ascending sorting.
     *
     * @param callable $selector
     * @param bool     $naturalSorting
     * @param bool     $caseSensitive
     *
     * @return ArrayListSorter
     */
    public function asc(callable $selector, bool $naturalSorting = FALSE, bool $caseSensitive = FALSE): ArrayListSorter
    {
        $flags = self::FLAG_ORDER_BY_ASC;

        if ($naturalSorting === TRUE)
            $flags = $flags | self::FLAG_ORDER_BY_NATURAL;

        if ($caseSensitive === TRUE)
            $flags = $flags | self::FLAG_ORDER_BY_CASE_SENSITIVE;
        else
            $flags = $flags | self::FLAG_ORDER_BY_CASE_INSENSITIVE;

        array_push($this->comparators, [$selector, $flags]);

        usort($this->source->toArray(),
            function ($item1, $item2) {
                return $this->compare($item1, $item2, $this->comparators);
            });

        return $this;
    }

    /**
     * Defines descending sorting.
     *
     * @param callable $selector
     * @param bool     $naturalSorting
     * @param bool     $caseSensitive
     *
     * @return ArrayListSorter
     */
    public function desc(callable $selector, bool $naturalSorting = FALSE, bool $caseSensitive = FALSE): ArrayListSorter
    {
        $flags = self::FLAG_ORDER_BY_DESC;

        if ($naturalSorting === TRUE)
            $flags = $flags | self::FLAG_ORDER_BY_NATURAL;

        if ($caseSensitive === TRUE)
            $flags = $flags | self::FLAG_ORDER_BY_CASE_SENSITIVE;
        else
            $flags = $flags | self::FLAG_ORDER_BY_CASE_INSENSITIVE;

        array_push($this->comparators, [$selector, $flags]);

        usort($this->source->toArray(),
            function ($item1, $item2) {
                return $this->compare($item1, $item2, $this->comparators);
            });

        return $this;
    }

    /**
     * Convert to list instance.
     *
     * @return ArrayList
     */
    public function toList(): ArrayList
    {
        return $this->source;
    }
}