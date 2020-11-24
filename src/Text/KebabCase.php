<?php

namespace AntonioKadid\WAPPKitCore\Text;

class KebabCase implements TextCaseInterface
{
    /** @var string[] */
    private $dismantled;

    /**
     * KebabCase constructor.
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

        return explode('-', $input);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]-]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    public static function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+(?:[[:alnum:]]+-?)+-[[:alnum:]]+$/', $input) != false;
    }

    /**
     * Convert to kebab-case.
     *
     * @return string
     */
    public function toKebabCase(): string
    {
        return strtolower(implode('-', $this->dismantled));
    }

    /**
     * Convert to SCREAMING-KEBAB-CASE.
     *
     * @return string
     */
    public function toScreamingKebabCase(): string
    {
        return strtoupper(implode('-', $this->dismantled));
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
        }, $this->dismantled));
    }
}
