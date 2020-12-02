<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

use AntonioKadid\WAPPKitCore\HTTP\Exceptions\NotFoundException;

/**
 * Class Router.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
final class Router
{
    /** @var array */
    private static $registry = [];

    /**
     * @return mixed
     */
    public static function execute(string $method, string $uri)
    {
        $regexes = array_keys(self::$registry);

        foreach ($regexes as $regex) {
            $params = [];

            if (preg_match($regex, $uri, $params) == false) {
                continue;
            }

            $route = self::$registry[$regex];

            switch ($route['type']) {
                case 'psr4Class':
                    $interfaces = class_implements($route['class']);
                    if (array_key_exists(RouteHandlerInterface::class, $interfaces)) {
                        $route = new $route['class']();
                    }

                    break;
                case 'handler':
                    if (!is_a($route['instance'], RouteHandlerInterface::class)) {
                        $route = $route['instance'];
                    }

                    break;
                case 'fileClass':
                    require_once $route['file'];
                    if (class_exists($route['class'], true)) {
                        $interfaces = class_implements($route['class']);
                        if (array_key_exists(RouteHandlerInterface::class, $interfaces)) {
                            $route = new $route['class']();
                        }
                    }

                    break;
            }

            if (!is_a($route, RouteHandlerInterface::class)) {
                continue;
            }

            // @var IRouteHandler $route
            return $route->follow($method, $uri, $params);
        }

        throw new NotFoundException($method, $uri);
    }

    /**
     * Register a class that will be loaded once the $filename is loaded.
     *
     * @param string $regex
     * @param string $filename
     * @param string $class
     */
    public static function registerFile(string $regex, string $filename, string $class)
    {
        if (!is_readable($filename)) {
            return;
        }

        if (!array_key_exists($regex, self::$registry)) {
            self::$registry[$regex] = ['type' => 'fileClass', 'class' => $class, 'file' => $filename];
        }
    }

    /**
     * Register a class that will be loaded based on internal PSR-4 defined namespaces.
     *
     * @param string $regEx
     * @param string $class
     */
    public static function registerPs4(string $regEx, string $class)
    {
        if (!array_key_exists($regEx, self::$registry)) {
            self::$registry[$regEx] = ['type' => 'psr4Class', 'class' => $class];
        }
    }

    /**
     * Register an object that implements RouteHandlerInterface.
     *
     * @param string                $regEx
     * @param RouteHandlerInterface $routeHandler
     */
    public static function registerRouteHandler(string $regEx, RouteHandlerInterface $routeHandler)
    {
        if (!array_key_exists($regEx, self::$registry)) {
            self::$registry[$regEx] = ['type' => 'handler', 'instance' => $routeHandler];
        }
    }
}
