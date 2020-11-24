<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Interface TextCaseInterface.
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
interface TextCaseInterface
{
    /**
     * Take apart the $input string based on the underlying text case.
     *
     * @param string $input
     * @return array
     */
    public static function dismantle(string $input): array;

    /**
     * Sanitize unknown characters based on the underlying text case.
     *
     * @param string $input
     *
     * @return string
     */
    public static function sanitize(string $input): string;

    /**
     * Check if the $input is valid based on the underlying text case.
     *
     * @param string $input
     *
     * @return bool
     */
    public static function valid(string $input): bool;
}
