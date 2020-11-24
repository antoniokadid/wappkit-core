<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\KebabCase;
use PHPUnit\Framework\TestCase;

class KebabCaseTest extends TestCase
{
    public function testDismantle()
    {
        $input1 = 'Test-Kebab-Case';
        $result = KebabCase::dismantle($input1);

        $this->assertIsArray($result);
        $this->assertEquals(3, count($result));
        $this->assertEquals('Test', $result[0]);
        $this->assertEquals('Kebab', $result[1]);
        $this->assertEquals('Case', $result[2]);

        $input2 = 'TestKebabCase';
        $result = KebabCase::dismantle($input2);

        $this->assertIsArray($result);
        $this->assertEquals(0, count($result));
    }

    public function testSanitize()
    {
        $input  = 'Test-K3b@b-C@se-Uns@ntized';
        $result = KebabCase::sanitize($input);

        $this->assertEquals('Test-K3bb-Cse-Unsntized', $result);

        $input2 = 'Nothing-To-Sanitize';

        $this->assertEquals('Nothing-To-Sanitize', KebabCase::sanitize($input2));
    }

    public function testToKebabCase()
    {
        $input = ['Test', 'Kebab', 'Case'];

        $kebabCase = new KebabCase($input);

        $this->assertEquals('test-kebab-case', $kebabCase->toKebabCase());
    }

    public function testToScreamingKebabCase()
    {
        $input = ['test', 'Screaming', 'kebab', 'case'];

        $kebabCase = new KebabCase($input);

        $this->assertEquals('TEST-SCREAMING-KEBAB-CASE', $kebabCase->toScreamingKebabCase());
    }

    public function testToTrainCase()
    {
        $input = ['test', 'train', 'case'];

        $kebabCase = new KebabCase($input);

        $this->assertEquals('Test-Train-Case', $kebabCase->toTrainCaseCase());
    }

    public function testValid()
    {
        $input1 = 'Test-kebab-Case';
        $this->assertTrue(KebabCase::valid($input1));

        $input2 = '-Test-Kebab-Case';
        $this->assertFalse(KebabCase::valid($input2));

        $input3 = 'Test-Kebab-Case-';
        $this->assertFalse(KebabCase::valid($input3));

        $input4 = 'Test-£nake-Case';
        $this->assertFalse(KebabCase::valid($input4));

        $input5 = '1Test-Kebab-Case';
        $this->assertFalse(KebabCase::valid($input5));

        $input6 = 'TestKebabCase';
        $this->assertFalse(KebabCase::valid($input6));
    }
}
