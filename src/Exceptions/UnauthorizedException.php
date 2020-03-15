<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;

/**
 * Class UnauthorizedException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class UnauthorizedException extends Exception
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message, Status::Unauthorized);
    }
}