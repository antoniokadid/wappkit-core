<?php

namespace AntonioKadid\WAPPKitCore\Programmability;

use AntonioKadid\WAPPKitCore\Arrays\Offset;

/**
 * Class ExecutionContext.
 *
 * @package AntonioKadid\WAPPKitCore\Programmability
 */
class ExecutionContext
{
    /** @var */
    private $parameters = null;
    /** @var ExecutionContext */
    private $parentContext = null;

    /**
     * ExecutionContext constructor.
     *
     * @param array                 $parameters
     * @param null|ExecutionContext $parentContext
     */
    public function __construct(array $parameters, ?ExecutionContext $parentContext = null)
    {
        $this->parameters    = $parameters;
        $this->parentContext = $parentContext;
    }

    /**
     * @return array
     */
    public function getParameters(): Offset
    {
        return new Offset($this->parameters);
    }

    /**
     * @return null|ExecutionContext
     */
    public function getParentContext(): ?ExecutionContext
    {
        return $this->parentContext;
    }
}
