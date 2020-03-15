<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Interface IEncoder
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
interface IEncoder
{
    /**
     * @param mixed $data
     * @param bool  $silent
     *
     * @return string|null
     */
    function encode($data, bool $silent = FALSE): ?string;
}