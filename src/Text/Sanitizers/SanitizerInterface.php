<?php

namespace AntonioKadid\WAPPKitCore\Text\Sanitizers;

/**
 * Interface SanitizerInterface.
 *
 * @package AntonioKadid\WAPPKitCore\Text\Sanitizers
 */
interface SanitizerInterface
{
    /**
     * @return string
     */
    public function sanitize(): string;
}
