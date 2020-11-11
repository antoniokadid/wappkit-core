<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidParameterValueException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class BoolTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class BoolTest extends TestCase
{
    /**
     * @throws InvalidParameterValueException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testClosure()
    {
        $invoker = new ClosureInvoker(
            function (bool $value) {
                return $value;
            });

        $result = $invoker->invoke(['value' => true]);
        $this->assertTrue($result);

        $result = $invoker->invoke(['value' => 1]);
        $this->assertTrue($result);

        $result = $invoker->invoke(['value' => '1']);
        $this->assertTrue($result);

        $result = $invoker->invoke(['value' => false]);
        $this->assertFalse($result);

        $result = $invoker->invoke(['value' => 0]);
        $this->assertFalse($result);

        $result = $invoker->invoke(['value' => '0']);
        $this->assertFalse($result);
    }
}
