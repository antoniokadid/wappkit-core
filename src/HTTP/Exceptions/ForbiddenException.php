<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class ForbiddenException.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Exceptions
 */
class ForbiddenException extends RouteException
{
    /**
     * ForbiddenException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param array          $parameters
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, array $parameters = [], ?Throwable $previous = null)
    {
        parent::__construct($method, $uri, $parameters, 'Forbidden.', Status::FORBIDDEN, $previous);
    }
}
