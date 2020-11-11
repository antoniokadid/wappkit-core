<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidParameterValueException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class InvalidParameterValueException extends Exception
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
