<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\SnakeCase;
use PHPUnit\Framework\TestCase;

class SnakeCaseTest extends TestCase
{
    public function testToCamelSnakeCase()
    {
        $snakeCase = new SnakeCase();
        $snakeCase->load('test camel snake case');

        $this->assertEquals('Test_Camel_Snake_Case', $snakeCase->toCamelSnakeCase());
    }

    public function testToScreamingSnakeCase()
    {
        $snakeCase = new SnakeCase();
        $snakeCase->load('test camel snake case');

        $this->assertEquals('TEST_CAMEL_SNAKE_CASE', $snakeCase->toScreamingSnakeCase());
    }

    public function testToSnakeCase()
    {
        $snakeCase = new SnakeCase();
        $snakeCase->load('Test Camel Snake Case');

        $this->assertEquals('test_camel_snake_case', $snakeCase->toSnakeCase());
    }
}
