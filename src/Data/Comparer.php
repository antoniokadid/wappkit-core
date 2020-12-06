<?php

namespace AntonioKadid\WAPPKitCore\Data;

use DateTime;

class Comparer
{
    /**
     * Compare dates.
     *
     * @param DateTime $date1
     * @param DateTime $date2
     *
     * @return int
     */
    public static function dates(DateTime $date1, DateTime $date2): int
    {
        return self::generic($date1, $date2);
    }

    /**
     * Compare floats.
     *
     * @param float $number1
     * @param float $number2
     *
     * @return int
     */
    public static function floats(float $number1, float $number2): int
    {
        return self::generic($number1, $number2);
    }
    /**
     * Compare anything.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return int
     */
    public static function generic($value1, $value2): int
    {
        return $value1 <=> $value2;
    }

    /**
     * Compare integers.
     *
     * @param int $number1
     * @param int $number2
     *
     * @return int
     */
    public static function integers(int $number1, int $number2): int
    {
        return self::generic($number1, $number2);
    }

    /**
     * Compare strings.
     *
     * @param string $value1
     * @param string $value2
     * @param bool   $sensitive
     * @param bool   $natural
     *
     * @return int
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function strings(string $value1, string $value2, bool $sensitive = false, bool $natural = false): int
    {
        if ($sensitive) {
            $result = $natural ? strnatcmp($value1, $value2) : strcmp($value1, $value2);
        } else {
            $result = $natural ? strnatcasecmp($value1, $value2) : strcasecmp($value1, $value2);
        }

        return
            $result === 0 ? 0 :
            ($result < 0 ? -1 :
            1);
    }
}
