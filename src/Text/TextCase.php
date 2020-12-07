<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Class TextCase.
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
class TextCase
{
    public const CAMEL_SNAKE           = 1;
    public const FLAT                  = 2;
    public const KEBAB                 = 3;
    public const LOWER_CAMEL           = 4;
    public const SCREAMING_KEBAB       = 5;
    public const SCREAMING_SNAKE       = 6;
    public const SNAKE                 = 7;
    public const TRAIN                 = 8;
    public const UNKNOWN               = 0;
    public const UPPER_CAMEL           = 9;
    public const UPPER_FLAT            = 10;

    /** @var string[] */
    private $parts = [];
    /** @var string */
    private $text;

    /**
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text  = $text;
        $this->parts = self::dismantle($text);
    }

    /**
     * Attempt to detect a valid text case.
     *
     * @param string $text
     *
     * @return int
     */
    public static function identify(string $text): int
    {
        return
            self::isLowerCamel($text) ? self::LOWER_CAMEL :
            (self::isCamelSnake($text) ? self::CAMEL_SNAKE :
            (self::isFlat($text) ? self::FLAT :
            (self::isKebab($text) ? self::KEBAB :
            (self::isScreamingKebab($text) ? self::SCREAMING_KEBAB :
            (self::isScreamingSnake($text) ? self::SCREAMING_SNAKE :
            (self::isSnake($text) ? self::SNAKE :
            (self::isTrain($text) ? self::TRAIN :
            (self::isUpperCamel($text) ? self::UPPER_CAMEL :
            (self::isUpperFlat($text) ? self::UPPER_FLAT :
            self::UNKNOWN)))))))));
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isCamelSnake(string $text): bool
    {
        return preg_match('/^([[:upper:]][0-9[:lower:]]+_?)+_[[:upper:]][0-9[:lower:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isFlat(string $text): bool
    {
        return preg_match('/^[0-9[:lower:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isKebab(string $text): bool
    {
        return preg_match('/^([0-9[:lower:]]+-?)+-[0-9[:lower:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isLowerCamel(string $text): bool
    {
        return preg_match('/^([[:lower:]]+[0-9[:lower:]]*[[:upper:]][0-9[:lower:]]*)+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isScreamingKebab(string $text): string
    {
        return preg_match('/^([0-9[:upper:]]+-?)+-[0-9[:upper:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isScreamingSnake(string $text): string
    {
        return preg_match('/^([0-9[:upper:]]+_?)+_[0-9[:upper:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isSnake(string $text): string
    {
        return preg_match('/^([0-9[:lower:]]+_?)+_[0-9[:lower:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isTrain(string $text): string
    {
        return preg_match('/^([[:upper:]][0-9[:lower:]]+-?)+-[[:upper:]][0-9[:lower:]]+$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isUpperCamel(string $text): string
    {
        return preg_match('/^([[:upper:]][0-9[:lower:]]+)+[[:upper:]]?$/', $text) === 1;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isUpperFlat(string $text): string
    {
        return preg_match('/^[0-9[:upper:]]+$/', $text) === 1;
    }

    /**
     * @param string $string
     *
     * @return TextCase
     */
    public function append(string $string): TextCase
    {
        $parts = self::dismantle($string);

        foreach ($parts as $part) {
            array_push($this->parts, $part);
        }

        return $this;
    }

    /**
     * @param string $string
     *
     * @return TextCase
     */
    public function prepend(string $string): TextCase
    {
        $parts = self::dismantle($string);
        if (empty($parts)) {
            return $this;
        }

        $parts = array_reverse($parts, false);

        foreach ($parts as $part) {
            array_unshift($this->parts, $part);
        }

        return $this;
    }

    /**
     * Convert to camelCase.
     *
     * @return string
     */
    public function toCamelCase(): string
    {
        $tmp = $this->parts;

        $first = array_shift($tmp);
        if ($first == null) {
            return '';
        }

        return array_reduce($tmp, function (string $carry, string $part) {
            return $carry . ucfirst(strtolower($part));
        }, strtolower($first));
    }

    /**
     * Convert to Camel_Snake_Case.
     *
     * @return string
     */
    public function toCamelSnakeCase(): string
    {
        return implode('_', array_map(function (string $part) {
            return ucfirst(strtolower($part));
        }, $this->parts));
    }

    /**
     * Convert to flatcase.
     *
     * @return string
     */
    public function toFlatCase(): string
    {
        return strtolower(implode('', $this->parts));
    }

    /**
     * Convert to kebab-case.
     *
     * @return string
     */
    public function toKebabCase(): string
    {
        return strtolower(implode('-', $this->parts));
    }

    /**
     * Convert to SCREAMING-KEBAB-CASE.
     *
     * @return string
     */
    public function toScreamingKebabCase(): string
    {
        return strtoupper(implode('-', $this->parts));
    }

    /**
     * Convert to CAMEL_SCREAMING_CASE.
     *
     * @return string
     */
    public function toScreamingSnakeCase(): string
    {
        return strtoupper(implode('_', $this->parts));
    }

    /**
     * Convert to snake-case.
     *
     * @return string
     */
    public function toSnakeCase(): string
    {
        return strtolower(implode('_', $this->parts));
    }

    /**
     * Convert to Train-Case.
     *
     * @return string
     */
    public function toTrainCaseCase(): string
    {
        return implode('-', array_map(function (string $part) {
            return ucfirst(strtolower($part));
        }, $this->parts));
    }

    /**
     * Convert to UpperCamelCase.
     *
     * @return string
     */
    public function toUpperCamelCase(): string
    {
        return array_reduce($this->parts, function (string $carry, string $part) {
            return $carry . ucfirst(strtolower($part));
        }, '');
    }

    /**
     * Convert to UPPERFLATCASE.
     *
     * @return string
     */
    public function toUpperFlatCase(): string
    {
        return strtoupper(implode('', $this->parts));
    }


    /**
     * Attempt to take apart a string.
     *
     * @param string $text
     *
     * @return string[]
     */
    private static function dismantle(string $text): array
    {
        $case = self::identify($text);

        switch ($case) {
            case TextCase::SNAKE:
            case TextCase::CAMEL_SNAKE:
            case TextCase::SCREAMING_SNAKE:
                return explode('_', $text);
            case TextCase::KEBAB:
            case TextCase::SCREAMING_KEBAB:
            case TextCase::TRAIN:
                return explode('-', $text);
            case TextCase::FLAT:
            case TextCase::UPPER_FLAT:
                return [$text];
            case TextCase::LOWER_CAMEL:
            case TextCase::UPPER_CAMEL:
                $result = preg_replace('/([[:upper:]])/', "\n$1", $text);
                if ($result == null) {
                    return [];
                }

                return explode("\n", trim($result));
            default:
                $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
                return $parts === false ? [] : $parts;
        }
    }
}
