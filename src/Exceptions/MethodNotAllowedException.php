<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;
use Throwable;

/**
 * Class MethodNotAllowedException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class MethodNotAllowedException extends Exception
{
    /** @var string */
    private $route;

    /**
     * MethodNotAllowedException constructor.
     *
     * @param string         $route
     * @param null|Throwable $previous
     */
    public function __construct(string $route, Throwable $previous = null)
    {
        parent::__construct('Method not allowed.', Status::METHOD_NOT_ALLOWED, $previous);

        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}
