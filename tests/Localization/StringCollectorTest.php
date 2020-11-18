<?php

namespace AntonioKadid\WAPPKitCore\Tests\Localization;

use AntonioKadid\WAPPKitCore\Localization\StringCollector;
use PHPUnit\Framework\TestCase;

use const AntonioKadid\WAPPKitCore\Localization\DEFAULT_DOMAIN;

class StringCollectorTest extends TestCase
{
    public function testCollectFromString()
    {
        $input = <<<EOT
        This is a test case
        Function: __('Hello World', 'the-domain');
        end of sample
        EOT;

        $collector = new StringCollector();
        $collected = $collector->collectFromString($input);

        $this->assertIsArray($collected);
        $this->assertTrue(array_key_exists('the-domain', $collected));
        $this->assertTrue(in_array('Hello World', $collected['the-domain']));

        $input = <<<EOT
        This is a test case
        Function1: __('Hello World 1', 'the-domain');
        Function2: __('Hello World 2', 'the-domain');
        Function3: __('Hello World 3');
        end of sample
        EOT;

        $collected = $collector->collectFromString($input);

        $this->assertIsArray($collected);
        $this->assertTrue(array_key_exists('the-domain', $collected));
        $this->assertTrue(array_key_exists(DEFAULT_DOMAIN, $collected));
        $this->assertEquals(2, count($collected['the-domain']));
        $this->assertEquals(1, count($collected[DEFAULT_DOMAIN]));
        $this->assertTrue(in_array('Hello World 1', $collected['the-domain']));
        $this->assertTrue(in_array('Hello World 2', $collected['the-domain']));
        $this->assertTrue(in_array('Hello World 3', $collected[DEFAULT_DOMAIN]));
    }
}