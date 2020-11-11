<?php

namespace AntonioKadid\WAPPKitCore\Tests\HTTP;

use AntonioKadid\WAPPKitCore\HTTP\Method;
use AntonioKadid\WAPPKitCore\HTTP\Routing\IRouteHandler;
use AntonioKadid\WAPPKitCore\HTTP\Routing\Router;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Class RouterTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\HTTP
 */
class RouterTest extends TestCase
{
    public function testBindMany()
    {
        $router = Router::for(Method::GET, '/route/15');
        $router->bindMany([
            '/route/{count}' => RouteHandler::class,
            false            => 14
        ]);

        $result = $router->execute();

        $this->assertEquals(15, $result);
    }
    public function testExecute()
    {
        $router = Router::for(Method::GET, '/route/5');
        $router->bind('/route/{count}', RouteHandler::class);

        $result = $router->execute();

        $this->assertEquals(5, $result);
    }
}

/**
 * Class RouteHandler.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\HTTP
 */
class RouteHandler implements IRouteHandler
{
    /**
     * @param int $count
     *
     * @return int
     */
    function countRouteHandler(int $count)
    {
        return $count;
    }

    /**
     * @param Throwable $throwable
     *
     * @return string
     */
    function error(Throwable $throwable)
    {
        return $throwable->getMessage();
    }

    /**
     * @return null|callable
     */
    function getErrorHandler(): ?callable
    {
        return [$this, 'error'];
    }

    /**
     * @return null|callable
     */
    function getImplementationHandler(): ?callable
    {
        return [$this, 'countRouteHandler'];
    }
    /**
     * @param string $method
     *
     * @return bool
     */
    function isMethodAllowed(string $method): bool
    {
        return $method === Method::GET;
    }
}
