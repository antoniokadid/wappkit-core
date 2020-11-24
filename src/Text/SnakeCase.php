<?php

namespace AntonioKadid\WAPPKitCore\Text;

class SnakeCase implements TextCaseInterface
{
    /** @var string[] */
    private $dismantled;

    /**
     * SnakeCase constructor.
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
        if (!static::valid($input)) {
            return [];
        }

        return explode('_', $input);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]_]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    public static function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+(?:[[:alnum:]]+_?)+_[[:alnum:]]+$/', $input) != false;
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
        }, $this->dismantled));
    }

    /**
     * Convert to CAMEL_SCREAMING_CASE.
     *
     * @return string
     */
    public function toScreamingSnakeCase(): string
    {
        return strtoupper(implode('_', $this->dismantled));
    }

    /**
     * Convert to snake-case.
     *
     * @return string
     */
    public function toSnakeCase(): string
    {
        return strtolower(implode('_', $this->dismantled));
    }
}
