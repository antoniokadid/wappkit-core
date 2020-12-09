<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class UnauthorizedException.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Exceptions
 */
class UnauthorizedException extends RouteException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param array          $parameters
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, array $parameters = [], ?Throwable $previous = null)
    {
        parent::__construct($method, $uri, $parameters, 'Unauthorized.', Status::UNAUTHORIZED, $previous);
    }
}
