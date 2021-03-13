<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

/**
 * Interface IInvoker.
 *
 * @package AntonioKadid\WAPPKitCore\Reflection
 */
interface IInvoker
{
    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function invoke(array $parameters = []);
}
