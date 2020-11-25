<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Class TextCase.
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
abstract class TextCase
{
    /** @var string[] */
    protected $parts = [];

    /**
     * @param string $input
     */
    public function load(string $input): void
    {
        if ($this->valid($input)) {
            $this->parts = $this->dismantle($input);

            return;
        }

        $this->parts = [];

        $parts = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);
        if ($parts === false) {
            return;
        }

        foreach ($parts as $part) {
            array_push($this->parts, ...$this->dismantle($this->sanitize($part)));
        }
    }

    /**
     * @param TextCase $textCase
     */
    public function loadFromTextCase(TextCase $textCase): void
    {
        $this->parts = $textCase->parts;
    }

    /**
     * Take apart the $input string based on the underlying text case.
     *
     * @param string $input
     *
     * @return array
     */
    abstract protected function dismantle(string $input): array;

    /**
     * Sanitize unknown characters based on the underlying text case.
     *
     * @param string $input
     *
     * @return string
     */
    abstract protected function sanitize(string $input): string;

    /**
     * Check if the $input is valid based on the underlying text case.
     *
     * @param string $input
     *
     * @return bool
     */
    abstract protected function valid(string $input): bool;
}
