<?php

namespace AntonioKadid\WAPPKitCore\Music\MP3\ID3v23;

/**
 * Interface IFrame
 *
 * @package AntonioKadid\WAPPKitCore\Music\MP3\ID3v23
 */
interface IFrame
{
    /**
     * @return array
     */
    public function extract(): array;
}