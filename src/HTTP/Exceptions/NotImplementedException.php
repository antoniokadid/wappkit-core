<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class NotImplementedException.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Exceptions
 */
class NotImplementedException extends RouteException
{
    /**
     * NotImplementedException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, Throwable $previous = null)
    {
        parent::__construct($method, $uri, 'Not Implemented.', Status::NOT_IMPLEMENTED, $previous);
    }
}
