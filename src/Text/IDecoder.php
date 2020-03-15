<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Interface IDecoder
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
interface IDecoder
{
    /**
     * @param string $text
     * @param bool   $silent
     *
     * @return NULL|mixed
     */
    function decode(string $text, bool $silent = FALSE);
}