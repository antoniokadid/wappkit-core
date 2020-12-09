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
    private const ROUTE_TYPE_CALLABLE = 'callable';
    private const ROUTE_TYPE_CLASS    = 'class';
    private const ROUTE_TYPE_FILE     = 'file';
    private const ROUTE_TYPE_HANDLER  = 'handler';

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
                case self::ROUTE_TYPE_CALLABLE:
                    return call_user_func_array($route['callable'], [$method, $uri, $params]);
                    break;
                case self::ROUTE_TYPE_CLASS:
                    if (!class_exists($route['class'], true)) {
                        break;
                    }

                    $interfaces = class_implements($route['class'], true);
                    if (array_key_exists(RouteHandlerInterface::class, $interfaces)) {
                        $route = new $route['class']();
                    }

                    break;
                case self::ROUTE_TYPE_FILE:
                    require_once $route['file'];

                    if (!class_exists($route['class'], true)) {
                        break;
                    }

                    $interfaces = class_implements($route['class'], true);
                    if (array_key_exists(RouteHandlerInterface::class, $interfaces)) {
                        $route = new $route['class']();
                    }

                    break;
                case self::ROUTE_TYPE_HANDLER:
                    if (!is_a($route['instance'], RouteHandlerInterface::class)) {
                        $route = $route['instance'];
                    }

                    break;
            }

            if (!is_a($route, RouteHandlerInterface::class)) {
                continue;
            }

            // @var IRouteHandler $route
            return $route->follow($method, $uri, $params);
        }

        throw new NotFoundException($method, $uri, $params);
    }

    /**
     * Register a class that will be loaded based on internal PSR-4 defined namespaces.
     *
     * @param string $regEx
     * @param string $class
     */
    public static function register(string $regEx, string $class): void
    {
        if (!array_key_exists($regEx, self::$registry)) {
            self::$registry[$regEx] = ['type' => self::ROUTE_TYPE_CLASS, 'class' => $class];
        }
    }

    /**
     * Register a callable that will be executed.
     *
     * @param string   $regex
     * @param callable $callable
     */
    public static function registerCallable(string $regex, callable $callable): void
    {
        if (!array_key_exists($regex, self::$registry)) {
            self::$registry[$regex] = ['type' => self::ROUTE_TYPE_CALLABLE, 'callable' => $callable];
        }
    }

    /**
     * Register a class that will be loaded once the $filename is loaded.
     *
     * @param string $regex
     * @param string $filename
     * @param string $class
     */
    public static function registerFile(string $regex, string $filename, string $class): void
    {
        if (!is_readable($filename)) {
            return;
        }

        if (!array_key_exists($regex, self::$registry)) {
            self::$registry[$regex] = ['type' => self::ROUTE_TYPE_FILE, 'file' => $filename, 'class' => $class];
        }
    }

    /**
     * Register an object that implements RouteHandlerInterface.
     *
     * @param string                $regEx
     * @param RouteHandlerInterface $routeHandler
     */
    public static function registerRouteHandler(string $regEx, RouteHandlerInterface $routeHandler): void
    {
        if (!array_key_exists($regEx, self::$registry)) {
            self::$registry[$regEx] = ['type' => self::ROUTE_TYPE_HANDLER, 'instance' => $routeHandler];
        }
    }
}
