<?php

namespace AntonioKadid\WAPPKitCore\Text;

class KebabCase extends TextCase
{
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
     * {@inheritdoc}
     */
    protected function dismantle(string $input): array
    {
        return explode('-', $input);
    }

    /**
     * {@inheritdoc}
     */
    protected function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]-]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    protected function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+(?:[[:alnum:]]+-?)+-[[:alnum:]]+$/', $input) != false;
    }
}
