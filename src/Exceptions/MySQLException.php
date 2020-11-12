<?php

namespace AntonioKadid\WAPPKitCore\Database\Exceptions;

use Exception;
use Throwable;

/**
 * Class MySQLException.
 *
 * @package AntonioKadid\WAPPKitCore\Database\Exceptions
 */
class MySQLException extends Exception
{
    /** @var array */
    private $parameters;
    /** @var string */
    private $query;

    /**
     * MySQLException constructor.
     *
     * @param string         $message
     * @param string         $sqlQuery
     * @param array          $sqlQueryParameters
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(
        string $message = '',
        string $sqlQuery = '',
        array $sqlQueryParameters = [],
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->query      = $sqlQuery;
        $this->parameters = $sqlQueryParameters;
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
    public function getQuery(): string
    {
        return $this->query;
    }
}
