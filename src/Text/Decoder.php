<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Class Decoder
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
abstract class Decoder implements IDecoder
{
    /** @var string */
    protected $error = '';
    /** @var int */
    protected $errorCode = 0;

    /**
     * @return string|null
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}