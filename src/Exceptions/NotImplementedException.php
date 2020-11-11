<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;
use Throwable;

/**
 * Class NotImplementedException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class NotImplementedException extends Exception
{
    /** @var string */
    private $route;

    /**
     * NotImplementedException constructor.
     *
     * @param string         $route
     * @param null|Throwable $previous
     */
    public function __construct(string $route, Throwable $previous = null)
    {
        parent::__construct('Not implemented.', Status::NOT_IMPLEMENTED, $previous);

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
