<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Extensibility\Action;
use PHPUnit\Framework\TestCase;

final class ActionTest extends TestCase
{
    public function testDo()
    {
        $uniqueId1 = Action::registry()->add('test-action', function() { echo 'Hello world'; });
        $uniqueId2 = Action::registry()->add('test-action', function() { echo 'Hello world second time'; });

        $this->expectOutputString('Hello worldHello world second time');
        Action::do('test-action');

        Action::registry()->remove('test-action', $uniqueId1);
        Action::registry()->remove('test-action', $uniqueId2);
    }

    public function testDoWithParameters() {
        $uniqueId = Action::registry()->add('test-action', function(string $parameter1, string $parameter2) { echo sprintf('%s %s', $parameter1, $parameter2); });

        $this->expectOutputString('Hello World');
        Action::do('test-action', 'Hello', 'World');

        Action::registry()->remove('test-action', $uniqueId);
    }
}
