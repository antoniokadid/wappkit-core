<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use Throwable;

/**
 * Class RouteException.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Exceptions
 */
class RouteException extends WAPPKitCoreException
{
    /** @var string */
    private $method;
    /** @var string */
    private $uri;

    /**
     * RouteException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $method, string $uri, string $message, int $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->method = $method;
        $this->uri    = $uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
