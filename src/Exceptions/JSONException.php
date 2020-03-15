<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use Exception;

/**
 * Class JsonException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class JSONException extends Exception
{
    /**
     * JsonException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}