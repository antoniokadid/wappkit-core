<?php

namespace AntonioKadid\WAPPKitCore\Tests\HTTP;

use AntonioKadid\WAPPKitCore\HTTP\Method;
use AntonioKadid\WAPPKitCore\HTTP\Routing\Router;
use function PHPUnit\Framework\assertEquals;

use PHPUnit\Framework\TestCase;

/**
 * Class RouterTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\HTTP
 */
class RouterTest extends TestCase
{
    public function testRegisterCallable()
    {
        Router::registerCallable(
            fn($method, $route, $params) => $params['count'],
            '/route\/(?<count>\d+)/');

        $result = Router::execute(Method::GET, '/route/15');

        assertEquals(15, $result);
    }
}
