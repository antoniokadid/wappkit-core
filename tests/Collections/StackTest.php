<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests\Collections;

use AntonioKadid\WAPPKitCore\Collections\Stack;
use PHPUnit\Framework\TestCase;

final class StackTest extends TestCase
{
    public function testPush(): void
    {
        $stack = new Stack([]);

        $stack->push('Test 1');
        $stack->push('Test 2');

        $this->assertEquals(2, $stack->count());

        $items = $stack->toArray();

        $this->assertEquals('Test 1', $items[0]);
        $this->assertEquals('Test 2', $items[1]);
    }

    public function testPop(): void
    {
        $stack = new Stack([]);

        $stack->push('Test 1');
        $stack->push('Test 2');

        $item = $stack->pop();

        $this->assertEquals('Test 2', $item);
        $this->assertEquals(1, $stack->count());

        $item = $stack->pop();

        $this->assertEquals('Test 1', $item);
        $this->assertEquals(0, $stack->count());
    }
}