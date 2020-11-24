<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\CamelCase;
use PHPUnit\Framework\TestCase;

class CamelCaseTest extends TestCase
{
    public function testToCamelCase()
    {
        $input = ['test', 'camel', 'case'];

        $camelCase = new CamelCase($input);

        $this->assertEquals('testCamelCase', $camelCase->toCamelCase());
    }

    public function testToFlatCase()
    {
        $input = ['Test', 'Camel', 'Case'];

        $camelCase = new CamelCase($input);

        $this->assertEquals('testcamelcase', $camelCase->toFlatCase());
    }

    public function testToUpperCamelCase()
    {
        $input = ['test', 'camel', 'case'];

        $camelCase = new CamelCase($input);

        $this->assertEquals('TestCamelCase', $camelCase->toUpperCamelCase());
    }

    public function testToUpperFlatCase()
    {
        $input = ['Test', 'Camel', 'Case'];

        $camelCase = new CamelCase($input);

        $this->assertEquals('TESTCAMELCASE', $camelCase->toUpperFlatCase());
    }
}
