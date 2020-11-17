<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Extensibility\Action;
use PHPUnit\Framework\TestCase;

final class ActionTest extends TestCase
{
    public function testDo()
    {
        $uniqueRef1 = Action::registry()->add('sample_action', function() { echo 'Hello world'; });
        $uniqueRef2 = Action::registry()->add('sample_action', function() { echo 'Hello world second time'; });

        $this->expectOutputString('Hello worldHello world second time');
        Action::do('sample_action');

        Action::registry()->remove($uniqueRef1);
        Action::registry()->remove($uniqueRef2);
    }

    public function testDoWithParameters() {
        $uniqueRef = Action::registry()->add('sample_action', function(string $parameter1, string $parameter2) { echo sprintf('%s %s', $parameter1, $parameter2); });

        $this->expectOutputString('Hello World');
        Action::do('sample_action', 'Hello', 'World');

        Action::registry()->remove($uniqueRef);
    }
}
