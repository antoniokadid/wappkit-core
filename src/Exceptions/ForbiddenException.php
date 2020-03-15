<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;

/**
 * Class ForbiddenException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class ForbiddenException extends Exception
{
    /**
     * ForbiddenException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message, Status::Forbidden);
    }
}