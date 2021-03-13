<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\Injector;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstructorTest.
 *
 * @package AntonioKadid\WAPPKitCore\Tests\Reflection
 */
class ConstructorTest extends TestCase
{
    public function testConstructor()
    {
        $instance = Injector::inject(TheSample::class, [['number' => 1]]);
        $this->assertEquals('THE_SAMPLE_1', $instance->process());
    }

    public function testConstructorWithClosure()
    {
        $result = Injector::inject(
            fn (TheSample $instance) => $instance->process(),
            ['number'                => 2]);

        $this->assertEquals('THE_SAMPLE_2', $result);
    }
}

class TheSample
{
    public function __construct(private int $number)
    {
    }

    public function process()
    {
        return sprintf('THE_SAMPLE_%d', $this->number);
    }
}
