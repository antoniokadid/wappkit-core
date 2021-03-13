<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\Injector;
use PHPUnit\Framework\TestCase;

class CallableTest extends TestCase
{
    public function testClosure()
    {
        $result = Injector::inject(
            fn (callable $value) => call_user_func($value, 5, 'test'),
            ['value'             => [$this, 'theCallable']]);

        $this->assertEquals('test_5', $result);
    }

    public function theCallable(int $number, string $test)
    {
        return sprintf('%s_%d', $test, $number);
    }
}
