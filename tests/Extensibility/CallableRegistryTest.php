<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Extensibility\CallableRegistry;
use PHPUnit\Framework\TestCase;

final class CallableRegistryTest extends TestCase
{
    /** @var CallableRegistry */
    private $registry;

    protected function setUp(): void {
        $this->registry = new CallableRegistry('test');
    }

    public function testAddAndRemove()
    {
        $this->assertFalse($this->registry->any('test-action'));

        $uniqueId1 = $this->registry->add('test-action', function() { echo 'Hello world'; });
        $uniqueId2 = $this->registry->add('test-action', function() { echo 'Hello world 2'; });

        $this->assertTrue($this->registry->any('test-action'));

        $this->registry->remove('test-action', $uniqueId1);

        $this->assertTrue($this->registry->any('test-action'));

        $this->registry->remove('test-action1234', $uniqueId2);

        $this->assertTrue($this->registry->any('test-action'));

        $this->registry->remove('test-action', $uniqueId2);

        $this->assertFalse($this->registry->any('test-action'));
    }
}
