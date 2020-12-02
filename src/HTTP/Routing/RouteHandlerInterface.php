<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

/**
 * Interface RouteHandlerInterface.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
interface RouteHandlerInterface
{
    /**
     * @param string $method
     * @param string $uri
     * @param array  $uriParams
     *
     * @return mixed
     */
    public function follow(string $method, string $uri, array $uriParams);
}
