<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use Throwable;

/**
 * Class InvalidArgumentException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class InvalidArgumentException extends WAPPKitCoreException
{
    /** @var string */
    private $argumentName;

    /**
     * InvalidArgumentException constructor.
     *
     * @param string         $argumentName
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $argumentName, string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->argumentName = $argumentName;
    }

    /**
     * @return string
     */
    public function getArgumentName(): string
    {
        return $this->argumentName;
    }
}
