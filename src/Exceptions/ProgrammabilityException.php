<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\Programmability\ExecutionContext;
use Exception;
use Throwable;

/**
 * Class ProgrammabilityException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class ProgrammabilityException extends Exception
{
    /** @var ExecutionContext */
    private $context;
    /** @var array */
    private $parameters;

    /**
     * ProgrammabilityException constructor.
     *
     * @param string                $message
     * @param array                 $parameters
     * @param null|ExecutionContext $context
     * @param null|Throwable        $previous
     */
    public function __construct(string $message = '', array $parameters = [], ?ExecutionContext $context = null, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->context    = $context;
        $this->parameters = $parameters;
    }

    /**
     * @return null|ExecutionContext
     */
    public function getContext(): ?ExecutionContext
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
