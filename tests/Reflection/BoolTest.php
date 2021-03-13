<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\Injector;
use PHPUnit\Framework\TestCase;

class BoolTest extends TestCase
{
    public function testClosure()
    {
        $result = Injector::inject(fn(bool $value) => $value, ['value' => true]);
        $this->assertTrue($result);

        $result = Injector::inject(fn(bool $value) => $value, ['value' => 1]);
        $this->assertTrue($result);

        $result = Injector::inject(fn(bool $value) => $value, ['value' => '1']);
        $this->assertTrue($result);

        $result = Injector::inject(fn(bool $value) => $value, ['value' => false]);
        $this->assertFalse($result);

        $result = Injector::inject(fn(bool $value) => $value, ['value' => 0]);
        $this->assertFalse($result);

        $result = Injector::inject(fn(bool $value) => $value, ['value' => '0']);
        $this->assertFalse($result);
    }
}
