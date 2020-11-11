<?php

namespace AntonioKadid\WAPPKitCore\Programmability;

/**
 * Interface IComponentImplementation.
 *
 * @package AntonioKadid\WAPPKitCore\Programmability
 */
interface IComponentImplementation
{
    /**
     * @return string
     */
    public function generate(): string;

    /**
     * @param array                 $parameters
     * @param null|ExecutionContext $context
     */
    public function setData(array $parameters = [], ExecutionContext $context = null): void;
}
