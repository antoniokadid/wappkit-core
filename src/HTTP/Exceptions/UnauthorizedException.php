<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class UnauthorizedException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class UnauthorizedException extends WAPPKitCoreException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string         $message
     * @param null|Throwable $previous
     */
    public function __construct(string $message = '', Throwable $previous = null)
    {
        parent::__construct($message, Status::UNAUTHORIZED, $previous);
    }
}
