<?php

namespace AntonioKadid\WAPPKitCore\Programmability;

use AntonioKadid\WAPPKitCore\Collections\Map;

/**
 * Class ExecutionContext.
 *
 * @package AntonioKadid\WAPPKitCore\Programmability
 */
class ExecutionContext extends Map
{
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
        parent::__construct($parameters);

        $this->parentContext = $parentContext;
    }

    /**
     * @return null|ExecutionContext
     */
    public function getParentContext(): ?ExecutionContext
    {
        return $this->parentContext;
    }
}
