<?php

namespace AntonioKadid\WAPPKitCore\Text;

use AntonioKadid\WAPPKitCore\Exceptions\DecodingException;

/**
 * Interface IDecoder.
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
interface IDecoder
{
    /**
     * @param string $text
     * @param bool   $silent
     *
     * @throws DecodingException
     *
     * @return null|mixed
     */
    public function decode(string $text, bool $silent = false);
}
