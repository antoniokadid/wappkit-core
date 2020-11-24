<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\SnakeCase;
use PHPUnit\Framework\TestCase;

class SnakeCaseTest extends TestCase
{
    public function testDismantle()
    {
        $input1 = 'Test_Snake_Case';
        $result = SnakeCase::dismantle($input1);

        $this->assertIsArray($result);
        $this->assertEquals(3, count($result));
        $this->assertEquals('Test', $result[0]);
        $this->assertEquals('Snake', $result[1]);
        $this->assertEquals('Case', $result[2]);

        $input2 = 'TestSnakeCase';
        $result = SnakeCase::dismantle($input2);

        $this->assertIsArray($result);
        $this->assertEquals(0, count($result));
    }

    public function testSanitize()
    {
        $input  = 'Test_Sn@ke_C@se_Uns@ntized';
        $result = SnakeCase::sanitize($input);

        $this->assertEquals('Test_Snke_Cse_Unsntized', $result);

        $input2 = 'Nothing_To_Sanitize';

        $this->assertEquals('Nothing_To_Sanitize', SnakeCase::sanitize($input2));
    }

    public function testToCamelSnakeCase()
    {
        $input = ['test', 'camel', 'snake', 'case'];

        $snakeCase = new SnakeCase($input);

        $this->assertEquals('Test_Camel_Snake_Case', $snakeCase->toCamelSnakeCase());
    }

    public function testToScreamingSnakeCase()
    {
        $input = ['test', 'camel', 'snake', 'case'];

        $snakeCase = new SnakeCase($input);

        $this->assertEquals('TEST_CAMEL_SNAKE_CASE', $snakeCase->toScreamingSnakeCase());
    }

    public function testToSnakeCase()
    {
        $input = ['Test', 'CamEl', 'Snake', 'Case'];

        $snakeCase = new SnakeCase($input);

        $this->assertEquals('test_camel_snake_case', $snakeCase->toSnakeCase());
    }

    public function testValid()
    {
        $input1 = 'Test_snake_Case';
        $this->assertTrue(SnakeCase::valid($input1));

        $input2 = '_Test_Snake_Case';
        $this->assertFalse(SnakeCase::valid($input2));

        $input3 = 'Test_Snake_Case_';
        $this->assertFalse(SnakeCase::valid($input3));

        $input4 = 'Test_£nake_Case';
        $this->assertFalse(SnakeCase::valid($input4));

        $input5 = '1Test_Snake_Case';
        $this->assertFalse(SnakeCase::valid($input5));

        $input6 = 'TestSnakeCase';
        $this->assertFalse(SnakeCase::valid($input6));
    }
}
