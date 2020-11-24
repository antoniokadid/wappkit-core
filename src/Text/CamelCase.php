<?php

namespace AntonioKadid\WAPPKitCore\Text;

class CamelCase implements TextCaseInterface
{
    /** @var string[] */
    private $dismantled;

    /**
     * CamelCase constructor.
     *
     * @param string[] $dismantled
     */
    public function __construct(array $dismantled)
    {
        $this->dismantled = $dismantled;
    }

    /**
     * {@inheritdoc}
     */
    public static function dismantle(string $input): array
    {
        $result = preg_replace('/([[:alnum:]])([[:upper:]])/', "$1\n$2", $input);
        if ($result == null) {
            return [];
        }

        return explode("\n", $result);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    public static function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+[[:alnum:]]*$/', $input) != false;
    }

    /**
     * Convert to camelCase.
     *
     * @return string
     */
    public function toCamelCase(): string
    {
        $parts = $this->dismantled;

        $first = array_shift($parts);
        if ($first == null) {
            return '';
        }

        return array_reduce($parts, function (string $carry, string $part) {
            return $carry . ucfirst(strtolower($part));
        }, strtolower($first));
    }

    /**
     * Convert to flatcase.
     *
     * @return string
     */
    public function toFlatCase(): string
    {
        return strtolower(implode('', $this->dismantled));
    }

    /**
     * Convert to UpperCamelCase.
     *
     * @return string
     */
    public function toUpperCamelCase(): string
    {
        return array_reduce($this->dismantled, function (string $carry, string $part) {
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
        return strtoupper(implode('', $this->dismantled));
    }
}
