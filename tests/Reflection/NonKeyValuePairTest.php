<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class NonKeyValuePairTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class NonKeyValuePairTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     */
    public function testNonKeyValuePair()
    {
        $invoker = new ClosureInvoker(function (int $number, string $text, bool $value) {
            return $value ? sprintf('%s_%d', $text, $number) : sprintf('%d_%s', $number, $text);
        });

        $data   = [1, 'test', true];
        $result = $invoker->invoke($data, false);
        $this->assertEquals('test_1', $result);

        $data   = [1, 'test', false];
        $result = $invoker->invoke($data, false);
        $this->assertEquals('1_test', $result);

        $data   = [1, 'test'];
        $result = $invoker->invoke($data, false);
        $this->assertEquals('1_test', $result);
    }
}
