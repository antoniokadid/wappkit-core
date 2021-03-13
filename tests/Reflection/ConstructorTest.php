<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\ClosureInvoker;
use AntonioKadid\WAPPKitCore\Reflection\ConstructorInvoker;
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
        $invoker = new ConstructorInvoker(TheSample::class);
        $this->assertEquals('THE_SAMPLE_1', $invoker->invoke(['number' => 1])->process());
    }

    public function testConstructorWithClosure()
    {
        $invoker = new ClosureInvoker(fn (TheSample $instance) => $instance->process());
        $this->assertEquals('THE_SAMPLE_2', $invoker->invoke(['number' => 2]));
    }
}

class TheSample
{
    private $_number;

    public function __construct(int $number)
    {
        $this->_number = $number;
    }

    public function process()
    {
        return sprintf('THE_SAMPLE_%d', $this->_number);
    }
}
