<?php

namespace AntonioKadid\WAPPKitCore\Text;

use AntonioKadid\WAPPKitCore\Exceptions\EncodingException;

/**
 * Interface IEncoder.
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
interface IEncoder
{
    /**
     * @param mixed $data
     * @param bool  $silent
     *
     * @throws EncodingException
     *
     * @return null|string
     */
    public function encode($data, bool $silent = false): ?string;
}
