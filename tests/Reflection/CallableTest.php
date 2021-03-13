<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class CallableTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class CallableTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testClosure()
    {
        $invoker = new ClosureInvoker(fn (callable $value) => call_user_func($value, 5, 'test'));

        $result = $invoker->invoke(['value' => [$this, 'theCallable']]);
        $this->assertEquals('test_5', $result);
    }

    public function theCallable(int $number, string $test)
    {
        return sprintf('%s_%d', $test, $number);
    }
}
