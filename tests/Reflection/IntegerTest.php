<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\CallableInjector;
use AntonioKadid\WAPPKitCore\Reflection\Injector;
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
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     */
    public function testCallable()
    {
        $result = Injector::inject([$this, 'theCallable'], ['value' => 15]);
        $this->assertEquals(20, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testClosure()
    {
        $result = Injector::inject(fn(int $value) => $value + 5,['value'       => 15]);
        $this->assertEquals(20, $result);

        $result = Injector::inject(fn (int $value = null) => $value + 5, ['value1' => 15]);
        $this->assertEquals(20, $result);

        $result = Injector::inject(fn (int $value = null, int $value1 = null) => $value + 5, ['value1' => 15]);
        $this->assertEquals(5, $result);

        $result = Injector::inject(fn (int $value = 6) => $value + 5, ['value' => 15]);
        $this->assertEquals(20, $result);

        $result = Injector::inject(fn(int $value) => $value + 5, ['value' => 15]);
        $this->assertEquals(20, $result);

        $result = Injector::inject(fn ($value = 6) => $value + 5, ['value' => 15]);
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
