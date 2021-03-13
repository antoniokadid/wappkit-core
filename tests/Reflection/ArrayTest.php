<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\Injector;
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testClosure()
    {
        $result = Injector::inject(
            fn(array $value) => $value,
            ['value'         => [5, 10, 15]]);

        $this->assertIsArray($result);
        $this->assertEquals(5, $result[0]);
        $this->assertEquals(10, $result[1]);
        $this->assertEquals(15, $result[2]);
    }
}
