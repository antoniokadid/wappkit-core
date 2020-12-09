<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class MethodNotAllowedException.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Exceptions
 */
class MethodNotAllowedException extends RouteException
{
    /**
     * MethodNotAllowedException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param array          $parameters
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, array $parameters = [], ?Throwable $previous = null)
    {
        parent::__construct($method, $uri, $parameters, 'Method Not Allowed.', Status::METHOD_NOT_ALLOWED, $previous);
    }
}
