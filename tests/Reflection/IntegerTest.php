<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\CallableInvoker;
use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use SebastianBergmann\Type\NullType;

/**
 * Class IntegerTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class IntegerTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testClosure()
    {
        $invoker = new ClosureInvoker(fn(int $value) => $value + 5);

        $result = $invoker->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker
            ->setClosure(fn (int $value = null) => $value + 5)
            ->invoke(['value1' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker
            ->setClosure(fn (int $value = null, int $value1 = null) => $value + 5)
            ->invoke(['value1' => 15]);
        $this->assertEquals(5, $result);

        $result = $invoker
            ->setClosure(fn (int $value = 6) => $value + 5)
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker
            ->setClosure(fn(int $value) => $value + 5)
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);

        $result = $invoker
            ->setClosure(fn ($value = 6) => $value + 5)
            ->invoke(['value' => 15]);
        $this->assertEquals(20, $result);
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
