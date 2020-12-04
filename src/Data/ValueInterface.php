<?php

namespace AntonioKadid\WAPPKitCore\Data;

use DateTime;

/**
 * Interface ValueInterface.
 *
 * @package AntonioKadid\WAPPKitCore\Data
 */
interface ValueInterface
{
    /**
     * 
     * Get the value at as array.
     *
     * @param null|array $default
     *
     * @return null|array
     */
    public function getArray(?array $default = null): ?array;

    /**
     * Get the value as boolean.
     *
     * @param null|bool $default
     * @param bool      $convert if true attempt to convert the value, else return the default
     *
     * @return null|bool
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getBool(?bool $default = null, bool $convert = true): ?bool;

    /**
     * Get the value as DateTime.
     *
     * @param null|DateTime $default
     * @param bool          $convert  if true attempt to convert the value, else return the default
     * @param string        $format   time format if the underlying value should be parsed
     * @param string        $timezone time zone of the DateTime that was created during parsing
     *
     * @return null|DateTime
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getDateTime(
        ?DateTime $default = null,
        bool $convert = true,
        string $format = DATE_ATOM,
        string $timezone = 'UTC'
    ): ?DateTime;

    /**
     * Get the value as float.
     *
     * @param null|float $default
     * @param bool       $convert if true attempt to convert the value, else return the default
     *
     * @return null|float
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getFloat(?float $default = null, bool $convert = true): ?float;

    /**
     * Get the value as integer.
     *
     * @param null|int $default
     * @param bool     $convert if true attempt to convert the value, else return the default
     *
     * @return null|int
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getInt(?int $default = null, bool $convert = true): ?int;

    /**
     * Get the value as a string.
     *
     * @param null|string $default
     * @param bool        $convert if true attempt to convert the value, else return the default
     *
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getString(?string $default = null, bool $convert = true): ?string;

    /**
     * Get the value as timestamp.
     *
     * @param mixed    $now
     * @param null|int $default
     *
     * @return null|int
     */
    public function getTimestamp(?int $now = null, ?int $default = null): ?int;

    /**
     * Get the value as trimmed string.
     *
     * @param null|string $default
     * @param bool        $convert  if true attempt to convert the value, else return the default
     * @param string      $charlist
     *
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getTrimString(?string $default = null, bool $convert = true, $charlist = " \t\n\r\0\x0B"): ?string;

    /**
     * Check if the underlined value is array.
     *
     * @return bool
     */
    public function isArray(): bool;

    /**
     * Check if the underlined value is boolean.
     *
     * @return bool
     */
    public function isBool(): bool;

    /**
     * Check if the underlined value is DateTime.
     *
     * @return bool
     */
    public function isDateTime(): bool;

    /**
     * Check if the underlined value is float.
     *
     * @return bool
     */
    public function isFloat(): bool;

    /**
     * Check if the underlined value is integer.
     *
     * @return bool
     */
    public function isInt(): bool;
    /**
     * Check if the underlined value is null.
     *
     * @return bool
     */
    public function isNull(): bool;

    /**
     * Check if the underlined value is string.
     *
     * @return bool
     */
    public function isString(): bool;
}
