<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class NotFoundException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class NotFoundException extends RouteException
{
    /**
     * NotFoundException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, Throwable $previous = null)
    {
        parent::__construct($method, $uri, 'Not Found.', Status::NOT_FOUND, $previous);
    }
}
