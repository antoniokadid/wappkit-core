<?php

namespace AntonioKadid\WAPPKitCore\Text;

class CamelCase extends TextCase
{
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
     * {@inheritdoc}
     */
    protected function dismantle(string $input): array
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
    protected function sanitize(string $input): string
    {
        return preg_replace('/[^[:alnum:]]/', '', $input) ?? $input;
    }

    /**
     * {@inheritdoc}
     */
    protected function valid(string $input): bool
    {
        return preg_match('/^[[:alpha:]]+[[:alnum:]]*$/', $input) != false;
    }
}
