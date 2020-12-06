<?php

namespace AntonioKadid\WAPPKitCore\Arrays;

use AntonioKadid\WAPPKitCore\Data\Comparer;
use AntonioKadid\WAPPKitCore\Flag;

class Sort
{
    private const FLAG_COMPARE_CASE_SENSITIVE   = 1;
    private const FLAG_COMPARE_NATURAL          = 2;
    private const FLAG_ORDER_ASC                = 4;
    private const FLAG_ORDER_DESC               = 8;

    /** @var array */
    private $array;

    /** @var array */
    private $modifiers = [];

    /**
     * @param array $array
     */
    private function __construct(array &$array)
    {
        $this->array = &$array;
    }

    /**
     * @param array $array
     *
     * @return Sort
     */
    public static function array(array &$array): Sort
    {
        return new Sort($array);
    }

    /**
     * Add an ascending sorting modifier.
     *
     * @param callable $selector
     * @param bool     $sensitive
     * @param bool     $natural
     *
     * @return Sort
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function asc(callable $selector, bool $sensitive = false, bool $natural = false): Sort
    {
        return $this->modifier(self::FLAG_ORDER_ASC, $selector, $sensitive, $natural);
    }

    /**
     * Add a descending sorting modifier.
     *
     * @param callable $selector
     * @param bool     $sensitive
     * @param bool     $natural
     *
     * @return Sort
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function desc(callable $selector, bool $sensitive = false, bool $natural = false): Sort
    {
        return $this->modifier(self::FLAG_ORDER_DESC, $selector, $sensitive, $natural);
    }

    /**
     * @suppressWarnings(PHPMD.ShortMethodName)
     */
    public function go(): void
    {
        usort(
            $this->array,
            function ($item1, $item2): int {
                return self::compare($item1, $item2, $this->modifiers);
            }
        );
    }

    /**
     * @param mixed $item1
     * @param mixed $item2
     * @param array $modifiers
     *
     * @return int
     */
    private static function compare($item1, $item2, array $modifiers): int
    {
        $currentModifier = array_shift($modifiers);
        if ($currentModifier == null) {
            return 0;
        }

        list($selector, $flags) = $currentModifier;

        $value1 = call_user_func($selector, $item1);
        $value2 = call_user_func($selector, $item2);

        $result = (is_string($value1) && is_string($value2)) ?
            Comparer::strings(
                $value1,
                $value2,
                Flag::exists($flags, self::FLAG_COMPARE_CASE_SENSITIVE),
                Flag::exists($flags, self::FLAG_COMPARE_NATURAL)
            ) :
            Comparer::generic($value1, $value2);

        return
            $result === 0 ? self::compare($item1, $item2, $modifiers) :
            (Flag::exists($flags, self::FLAG_ORDER_DESC) ? -$result :
            $result);
    }

    /**
     * @param int      $sortFlags
     * @param callable $selector
     * @param bool     $sensitive
     * @param bool     $natural
     *
     * @return Sort
     */
    private function modifier(int $sortFlags, callable $selector, bool $sensitive, bool $natural): Sort
    {
        if ($sensitive === true) {
            $sortFlags = Flag::add($sortFlags, self::FLAG_COMPARE_CASE_SENSITIVE);
        }

        if ($natural === true) {
            $sortFlags = Flag::add($sortFlags, self::FLAG_COMPARE_NATURAL);
        }

        array_push($this->modifiers, [$selector, $sortFlags]);

        return $this;
    }
}
