<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

/**
 * Interface IRouteHandler.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
interface IRouteHandler
{
    /**
     * @return null|callable
     */
    public function getErrorHandler(): ?callable;

    /**
     * @return callable
     */
    public function getImplementationHandler(): ?callable;

    /**
     * @param string $method
     *
     * @return bool
     */
    public function isMethodAllowed(string $method): bool;
}
