<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Extensibility\CallableRegistry;
use PHPUnit\Framework\TestCase;

final class CallableRegistryTest extends TestCase
{
    public function testConstructorWithInvalidName()
    {
        $this->expectException(InvalidArgumentException::class);
        new CallableRegistry('test!@');
    }

    public function testConstructorWithValidName()
    {
        $registry = new CallableRegistry('test');

        $this->assertTrue($registry instanceof CallableRegistry);
    }

    public function testAddActionWithInvalidName()
    {
        $registry = new CallableRegistry('test');

        $this->expectException(InvalidArgumentException::class);
        $registry->add('sample@action', function() { echo 'Hello world'; });
    }

    public function testAddActionWithValidName()
    {
        $registry = new CallableRegistry('test');
        $registry->add('sample_action', function() { echo 'Hello world'; });
        $registry->add('sample-action', function() { echo 'Hello world'; });

        $this->assertTrue($registry->any('sample_action'));
    }

    public function testRemove()
    {
        $registry = new CallableRegistry('test');

        $this->assertFalse($registry->any('sample_action'));

        $uniqueRef1 = $registry->add('sample_action', function() { echo 'Hello world'; });
        $uniqueRef2 = $registry->add('sample_action', function() { echo 'Hello world 2'; });

        $this->assertTrue($registry->any('sample_action'));

        $registry->remove($uniqueRef1);

        $this->assertTrue($registry->any('sample_action'));

        $registry->remove($uniqueRef2);

        $this->assertFalse($registry->any('sample_action'));
    }
}
