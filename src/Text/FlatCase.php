<?php

namespace AntonioKadid\WAPPKitCore\Text;

class FlatCase extends TextCase
{
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
     * Convert to UPPERFLATCASE.
     *
     * @return string
     */
    public function toUpperFlatCase(): string
    {
        return strtoupper(implode('', $this->parts));
    }

    /**
     * {@inheritdoc}
     */
    protected function dismantle(string $input): array
    {
        $result = preg_split('/([^[:alnum:]])/', $input, PREG_SPLIT_NO_EMPTY);

        return $result !== false ? $result : [];
    }

    /**
     * {@inheritdoc}
     */
    protected function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    protected function valid(string $input): bool
    {
        return preg_match('/^[[:alnum:]]+$/', $input) != false;
    }
}
