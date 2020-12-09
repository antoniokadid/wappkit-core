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
    /** @var array */
    private $parameters = [];
    /** @var string */
    private $uri;

    /**
     * RouteException constructor.
     *
     * @param string         $method
     * @param string         $uri
     * @param array          $parameters
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(
        string $method,
        string $uri,
        array $parameters = [],
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->method     = $method;
        $this->uri        = $uri;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
