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
     * @param array          $parameters
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, array $parameters = [], ?Throwable $previous = null)
    {
        parent::__construct($method, $uri, $parameters, 'Not Found.', Status::NOT_FOUND, $previous);
    }
}
