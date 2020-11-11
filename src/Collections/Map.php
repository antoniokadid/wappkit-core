<?php

namespace AntonioKadid\WAPPKitCore\Collections;

use ArrayAccess;
use DateTime;
use DateTimeZone;

/**
 * Class Map.
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class Map extends Collection implements ArrayAccess
{
    /**
     * Map constructor.
     *
     * @param array $source An array to initialize map. Array keys are preserved. [optional]
     */
    public function __construct(array $source = [])
    {
        parent::__construct($source);
    }

    /**
     * Get the value at offset as array.
     *
     * @param mixed      $offset
     * @param null|array $default
     *
     * @return null|array
     */
    public function getArray($offset, ?array $default = null): ?array
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        return is_array($value) ? $value : $default;
    }

    /**
     * Get the value at offset as boolean.
     *
     * @param mixed     $offset
     * @param null|bool $default
     *
     * @return null|bool
     */
    public function getBool($offset, ?bool $default = null): ?bool
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        if (is_bool($value)) {
            return $value;
        }

        return boolval($value);
    }

    /**
     * Get the value at offset as DateTime.
     *
     * @param mixed         $offset
     * @param null|DateTime $default
     * @param string        $expectedFormat
     * @param string        $timezone
     *
     * @return null|DateTime
     */
    public function getDateTime(
        $offset,
        ?DateTime $default = null,
        string $expectedFormat = DATE_ISO8601,
        string $timezone = 'UTC'
    ): ?DateTime {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        $dateTime = DateTime::createFromFormat($expectedFormat, $value, new DateTimeZone($timezone));

        return $dateTime === false ? $default : $dateTime;
    }

    /**
     * Get the value at offset as float.
     *
     * @param mixed      $offset
     * @param null|float $default
     *
     * @return null|float
     */
    public function getFloat($offset, ?float $default = null): ?float
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        if (is_float($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return floatval($value);
        }

        return $default;
    }

    /**
     * Get the value at offset as integer.
     *
     * @param mixed    $offset
     * @param null|int $default
     *
     * @return null|int
     */
    public function getInt($offset, ?int $default = null): ?int
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return intval($value);
        }

        return $default;
    }

    /**
     * Get the value at offset as a string.
     *
     * @param mixed       $offset
     * @param null|string $default
     *
     * @return null|string
     */
    public function getString($offset, ?string $default = null): ?string
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);
        if (is_string($value)) {
            return $value;
        }

        return strval($value);
    }

    /**
     * Get the value at offset as timestamp.
     *
     * @param mixed    $offset
     * @param null|int $default
     *
     * @return null|int
     */
    public function getTimestamp($offset, ?int $default = null): ?int
    {
        if (!$this->offsetExists($offset)) {
            return $default;
        }

        $value = $this->offsetGet($offset);

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && is_numeric($value)) {
            $res = strtotime($value);
            return $res === false ? $default : $res;
        }

        return $default;
    }

    /**
     * Get the value at offset as a string (trim).
     *
     * @param mixed       $offset
     * @param null|string $default
     *
     * @return null|string
     */
    public function getTrimString($offset, ?string $default = null): ?string
    {
        $string = $this->getString($offset, $default);

        if ($string == null) {
            return $string;
        }

        return trim($string);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->source);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->source[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->source[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->source[$offset]);
    }
}
