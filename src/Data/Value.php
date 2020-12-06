<?php

namespace AntonioKadid\WAPPKitCore\Data;

use DateTime;
use DateTimeZone;

/**
 * Class Value.
 *
 * @package AntonioKadid\WAPPKitCore\Data
 */
class Value implements ValueInterface
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value at as array.
     *
     * @param null|array $default
     *
     * @return null|array
     */
    public function getArray(?array $default = null): ?array
    {
        return
            $this->isNull() ? $default :
            ($this->isArray() ? $this->value :
            $default);
    }

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
    public function getBool(?bool $default = null, bool $convert = true): ?bool
    {
        return
            $this->isNull() ? $default :
            ($this->isBool() ? $this->value :
            ($convert ? boolval($this->value) :
            $default));
    }

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
    ): ?DateTime {
        if ($this->isDateTime()) {
            return $this->value;
        }

        if ($this->isNull() || !$convert) {
            return $default;
        }

        $value    = strval($this->value);
        $dateTime = DateTime::createFromFormat($format, $value, new DateTimeZone($timezone));

        return $dateTime === false ? $default : $dateTime;
    }

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
    public function getFloat(?float $default = null, bool $convert = true): ?float
    {
        return
            $this->isNull() ? $default :
            ($this->isFloat() ? $this->value :
            ($convert ? floatval($this->value) :
            $default));
    }

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
    public function getInt(?int $default = null, bool $convert = true): ?int
    {
        return
            $this->isNull() ? $default :
            ($this->isInt() ? $this->value :
            ($convert ? intval($this->value) :
            $default));
    }

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
    public function getString(?string $default = null, bool $convert = true): ?string
    {
        return
            $this->isNull() ? $default :
            ($this->isString() ? $this->value :
            ($convert ? strval($this->value) :
            $default));
    }

    /**
     * Get the value as timestamp.
     *
     * @param mixed    $now
     * @param null|int $default
     *
     * @return null|int
     */
    public function getTimestamp(?int $now = null, ?int $default = null): ?int
    {
        if ($this->isNull() || !$this->isString()) {
            return $default;
        }

        $result = strtotime($this->value, $now === null ? time() : $now);

        return $result === false ? $default : $result;
    }

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
    public function getTrimString(?string $default = null, bool $convert = true, $charlist = " \t\n\r\0\x0B"): ?string
    {
        return
            $this->isNull() ? $default :
            ($this->isString() ? trim($this->value, $charlist) :
            ($convert ? trim(strval($this->value), $charlist) :
            $default));
    }

    /**
     * Check if the underlined value is array.
     *
     * @return bool
     */
    public function isArray(): bool
    {
        return is_array($this->value);
    }

    /**
     * Check if the underlined value is boolean.
     *
     * @return bool
     */
    public function isBool(): bool
    {
        return is_bool($this->value);
    }

    /**
     * Check if the underlined value is DateTime.
     *
     * @return bool
     */
    public function isDateTime(): bool
    {
        return is_a($this->value, DateTime::class);
    }

    /**
     * Check if the underlined value is float.
     *
     * @return bool
     */
    public function isFloat(): bool
    {
        return is_float($this->value);
    }

    /**
     * Check if the underlined value is integer.
     *
     * @return bool
     */
    public function isInt(): bool
    {
        return is_int($this->value);
    }

    /**
     * Check if the underlined value is null.
     *
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->value === null;
    }

    /**
     * Check if the underlined value is string.
     *
     * @return bool
     */
    public function isString(): bool
    {
        return is_string($this->value);
    }
}
