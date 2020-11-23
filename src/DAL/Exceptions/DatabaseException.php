<?php

namespace AntonioKadid\WAPPKitCore\DAL\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use Throwable;

/**
 * Class DatabaseException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class DatabaseException extends WAPPKitCoreException
{
    /** @var array */
    private $parameters;
    /** @var string */
    private $query;

    /**
     * DatabaseException constructor.
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
