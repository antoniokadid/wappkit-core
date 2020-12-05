<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\TextCase;
use function PHPUnit\Framework\assertEquals;

use PHPUnit\Framework\TestCase;

class TextCaseTest extends TestCase
{
    public function testIdentify()
    {
        $text = 'antonioKadidIsTesting';
        assertEquals(TextCase::LOWER_CAMEL, TextCase::identify($text));

        $text = 'Antonio_Kadid_Is_Testing';
        assertEquals(TextCase::CAMEL_SNAKE, TextCase::identify($text));

        $text = 'antoniokadidistesting';
        assertEquals(TextCase::FLAT, TextCase::identify($text));

        $text = 'antonio-kadid-is-testing';
        assertEquals(TextCase::KEBAB, TextCase::identify($text));

        $text = 'ANTONIO-KADID-IS-TESTING';
        assertEquals(TextCase::SCREAMING_KEBAB, TextCase::identify($text));

        $text = 'ANTONIO_KADID_IS_TESTING';
        assertEquals(TextCase::SCREAMING_SNAKE, TextCase::identify($text));

        $text = 'antonio_kadid_is_testing';
        assertEquals(TextCase::SNAKE, TextCase::identify($text));

        $text = 'Antonio-Kadid-Is-Testing';
        assertEquals(TextCase::TRAIN, TextCase::identify($text));

        $text = 'AntonioKadidIsTesting';
        assertEquals(TextCase::UPPER_CAMEL, TextCase::identify($text));

        $text = 'ANTONIOKADIDISTESTING';
        assertEquals(TextCase::UPPER_FLAT, TextCase::identify($text));

        $text = 'Antonio@Kadid--Is-Testing';
        assertEquals(TextCase::UNKNOWN, TextCase::identify($text));
    }

    public function testToCamelCase()
    {
        $case = new TextCase("Test\ncamel\ncase");
        assertEquals('testCamelCase', $case->toCamelCase());

        $case = new TextCase("Test\nc@mel\nc@se");
        assertEquals('testC@melC@se', $case->toCamelCase());
    }

    public function testToCamelSnakeCase()
    {
        $case = new TextCase('test camel snake case');
        assertEquals('Test_Camel_Snake_Case', $case->toCamelSnakeCase());
    }

    public function testToFlatCase()
    {
        $case = new TextCase('Test_Flat_Case');
        assertEquals('testflatcase', $case->toFlatCase());

        $case = new TextCase('Test_Fl@t_c@se');
        assertEquals('test_fl@t_c@se', $case->toFlatCase());
    }

    public function testToKebabCase()
    {
        $case = new TextCase('Test-kebab-Case');
        assertEquals('test-kebab-case', $case->toKebabCase());
    }

    public function testToScreamingKebabCase()
    {
        $case = new TextCase('testScreamingKebabCase');
        assertEquals('TEST-SCREAMING-KEBAB-CASE', $case->toScreamingKebabCase());
    }

    public function testToScreamingSnakeCase()
    {
        $case = new TextCase('test-camel-snake-case');
        assertEquals('TEST_CAMEL_SNAKE_CASE', $case->toScreamingSnakeCase());
    }

    public function testToSnakeCase()
    {
        $case = new TextCase('TestCamelSnakeCase');
        assertEquals('test_camel_snake_case', $case->toSnakeCase());
    }

    public function testToTrainCase()
    {
        $case = new TextCase('test_train_case');
        assertEquals('Test-Train-Case', $case->toTrainCaseCase());
    }

    public function testToUpperCamelCase()
    {
        $case = new TextCase('test camel case');
        assertEquals('TestCamelCase', $case->toUpperCamelCase());
    }

    public function testToUpperFlatCase()
    {
        $case = new TextCase('test flat case');
        assertEquals('TESTFLATCASE', $case->toUpperFlatCase());
    }
}
