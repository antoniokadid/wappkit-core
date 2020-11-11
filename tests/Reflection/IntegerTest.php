<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidParameterValueException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\CallableInvoker;
use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class IntegerTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class IntegerTest extends TestCase
{
    /**
     * @throws InvalidParameterValueException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     */
    public function testCallable()
    {
        $invoker = new CallableInvoker([$this, 'theCallable']);
        $result  = $invoker->invoke(['value' => 15]);
        $this->assertEquals(20, $result);
    }
    /**
     * @throws InvalidParameterValueException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testClosure()
    {
        $invoker = new ClosureInvoker(
            function (int $value) {
                return $value + 5;
            });

        $result = $invoker->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $this->expectException(InvalidParameterValueException::class);
        $invoker->invoke(['value1' => 15]);

        $invoker->setClosure(
            function (int $value = null) {
                return $value + 5;
            });
        $result = $invoker->invoke(['value1' => 15]);
        $this->assertNull($result);

        $result = $invoker->setClosure(
            function (int $value = 6) {
                return $value + 5;
            })
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker->invoke(['value1' => 15]);
        $this->assertEquals(11, $result);

        $result = $invoker->setClosure(
            function ($value) {
                return $value + 5;
            })
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker->setClosure(
            function ($value = 6) {
                return $value + 5;
            })
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker->invoke(['value1' => 15]);
        $this->assertEquals(11, $result);
    }

    /**
     * @param int $value
     *
     * @return int
     */
    public function theCallable(int $value): int
    {
        return $value + 5;
    }
}
