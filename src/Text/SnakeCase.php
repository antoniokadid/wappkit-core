<?php

namespace AntonioKadid\WAPPKitCore\Text;

class SnakeCase extends TextCase
{
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
     * {@inheritdoc}
     */
    protected function dismantle(string $input): array
    {
        return explode('_', $input);
    }

    /**
     * {@inheritdoc}
     */
    protected function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]_]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    protected function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+(?:[[:alnum:]]+_?)+_[[:alnum:]]+$/', $input) != false;
    }
}
