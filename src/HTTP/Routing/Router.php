<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidParameterValueException;
use AntonioKadid\WAPPKitCore\Exceptions\MethodNotAllowedException;
use AntonioKadid\WAPPKitCore\Exceptions\NotImplementedException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\CallableInvoker;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * Class Router.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
final class Router
{
    /** @var Router */
    private static $routerInstance = null;
    /** @var null|callable */
    private $globalThrowableHandler = null;
    /** @var string */
    private $queryString;
    /** @var string */
    private $requestMethod;
    /** @var string */
    private $requestUrl;
    /** @var array */
    private $routeRegistry = [];

    /**
     * Router constructor.
     *
     * @param string $requestMethod
     * @param string $requestUrl
     * @param string $queryString
     */
    private function __construct(string $requestMethod, string $requestUrl, string $queryString = '')
    {
        $this->requestMethod = $requestMethod;
        $this->requestUrl    = $requestUrl;
        $this->queryString   = $queryString;
    }

    /**
     * @param string $requestMethod
     * @param string $requestUrl
     * @param string $queryString
     *
     * @return Router
     */
    public static function for(string $requestMethod, string $requestUrl, string $queryString = ''): Router
    {
        if (self::$routerInstance == null) {
            self::$routerInstance = new Router($requestMethod, $requestUrl, $queryString);
        }

        self::$routerInstance->requestMethod = $requestMethod;
        self::$routerInstance->requestUrl    = $requestUrl;
        self::$routerInstance->queryString   = $queryString;

        return self::$routerInstance;
    }

    /**
     * @param string $route
     * @param string $className
     */
    public function bind(string $route, string $className): void
    {
        $pattern = self::routeToRegExPattern($route);

        if (!array_key_exists($route, $this->routeRegistry)) {
            $this->routeRegistry[$route] = ['pattern' => $pattern, 'class' => $className];
        }
    }

    /**
     * @param array $routes
     */
    public function bindMany(array $routes): void
    {
        foreach ($routes as $route => $className) {
            $this->bind(strval($route), strval($className));
        }
    }

    /**
     * @param null|callable $callable
     *
     * @return $this
     */
    public function catch(?callable $callable): Router
    {
        $this->globalThrowableHandler = $callable;

        return $this;
    }

    /**
     * @throws InvalidParameterValueException
     * @throws MethodNotAllowedException
     * @throws NotImplementedException
     * @throws ReflectionException
     * @throws Throwable
     * @throws UnknownParameterTypeException
     *
     * @return null|mixed
     */
    public function execute()
    {
        try {
            if (empty($this->routeRegistry)) {
                return null;
            }

            $matchingRoute = $this->findMatchingRoute();
            if ($matchingRoute == null) {
                return null;
            }

            $route = $matchingRoute['route'];
            $class = $matchingRoute['class'];
            $data  = $matchingRoute['data'];

            if (!class_exists($class, true)) {
                return null;
            }

            $class = new ReflectionClass($class);
            if (!$class->implementsInterface(IRouteHandler::class)) {
                return null;
            }

            /** @var IRouteHandler $instance */
            $instance = $class->newInstance();
            if (!$instance->isMethodAllowed($this->requestMethod)) {
                throw new MethodNotAllowedException($route);
            }

            $implementationHandler = $instance->getImplementationHandler();
            if ($implementationHandler == null) {
                throw new NotImplementedException($route);
            }

            $callableInvoker = new CallableInvoker($implementationHandler);

            try {
                return $callableInvoker->invoke($data);
            } catch (Throwable $throwable) {
                $errorHandler = $instance->getErrorHandler();
                if ($errorHandler != null) {
                    return call_user_func($errorHandler, $throwable);
                }

                throw $throwable;
            }
        } catch (Throwable $globalThrowable) {
            if (!is_callable($this->globalThrowableHandler)) {
                throw $globalThrowable;
            }

            return call_user_func($this->globalThrowableHandler, $globalThrowable);
        }
    }

    /**
     * @param string $route
     */
    public function unbind(string $route): void
    {
        if (array_key_exists($route, $this->routeRegistry)) {
            unset($this->routeRegistry[$route]);
        }
    }

    /**
     * Converts a route into regex pattern.
     *
     * @param string $route
     *
     * @return string
     */
    private static function routeToRegExPattern(string $route): string
    {
        $pattern = preg_replace_callback_array([
            '/\\{(\\w+)\\}/i' => function ($match) {
                return sprintf('(?<%s>(?:[^/\\?]+))', $match[1]);
            },
            '/\\*\\*/' => function ($match) {
                return '(?:[^\\?]+)';
            },
            '/\\*/' => function ($match) {
                return '(?:[^/\\?]+)';
            }
        ], $route);

        if (strpos($pattern, '/') !== 0) {
            $pattern = "/{$pattern}";
        }

        return sprintf('`^%s(?:\\?.*$|$)`i', $pattern);
    }

    /**
     * @return null|array
     */
    private function findMatchingRoute(): ?array
    {
        $routePatterns = array_combine(array_keys($this->routeRegistry), array_column($this->routeRegistry, 'pattern'));
        if (empty($routePatterns)) {
            return null;
        }

        foreach ($routePatterns as $route => $routePattern) {
            if (@preg_match($routePattern, $this->requestUrl, $urlParameters) !== 1) {
                continue;
            }

            // URLDecode $urlParameters
            array_walk(
                $urlParameters,
                function (&$urlEncodedParameter) {
                    $urlEncodedParameter = urldecode($urlEncodedParameter);
                }
            );

            // Load query string
            parse_str($this->queryString, $queryParameters);

            // Combine the two parameter arrays.
            $data = $urlParameters + $queryParameters;

            return [
                'route' => $route,
                'class' => $this->routeRegistry[$route]['class'],
                'data'  => $data
            ];
        }

        return null;
    }
}
