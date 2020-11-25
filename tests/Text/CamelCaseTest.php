<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\CamelCase;
use PHPUnit\Framework\TestCase;

class CamelCaseTest extends TestCase
{
    public function testToCamelCase()
    {
        $camelCase = new CamelCase();

        $camelCase->load("Test\ncamel\ncase");
        $this->assertEquals('testCamelCase', $camelCase->toCamelCase());

        $camelCase->load("Test\nc@mel\nc@se");
        $this->assertEquals('testCmelCse', $camelCase->toCamelCase());

    }

    public function testToUpperCamelCase()
    {
        $camelCase = new CamelCase();
        $camelCase->load('test camel case');

        $this->assertEquals('TestCamelCase', $camelCase->toUpperCamelCase());
    }
}
