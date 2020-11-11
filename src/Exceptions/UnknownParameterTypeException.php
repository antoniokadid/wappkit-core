<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use Exception;
use Throwable;

/**
 * Class UnknownParameterTypeException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class UnknownParameterTypeException extends Exception
{
    /** @var string */
    private $parameterName;

    public function __construct(string $parameterName, string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->parameterName = $parameterName;
    }

    /**
     * @return string
     */
    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
