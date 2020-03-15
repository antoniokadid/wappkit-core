<?php

namespace AntonioKadid\WAPPKitCore\Text;

/**
 * Class Encoder
 *
 * @package AntonioKadid\WAPPKitCore\Text
 */
abstract class Encoder implements IEncoder
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