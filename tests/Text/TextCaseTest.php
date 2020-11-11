<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\TextCase;
use PHPUnit\Framework\TestCase;

class TextCaseTest extends TestCase
{
    private $_text = '';

    public function setUp(): void
    {
        parent::setUp();

        $this->_text = <<<EOT
Hello world
numbers 1 to 10 and 
some unicode chars
Γειά αυτό είναι παράδειγμα
EOT;
    }

    public function testKebab()
    {
        $kebab = TextCase::toKebab($this->_text);
        $this->assertEquals('hello-world-numbers-1-to-10-and-some-unicode-chars-γειά-αυτό-είναι-παράδειγμα', $kebab);
    }

    public function testLowerCamelCase()
    {
        $lowerCamelCase = TextCase::toLowerCamel($this->_text);
        $this->assertEquals('helloWorldNumbers1To10AndSomeUnicodeCharsΓειάΑυτόΕίναιΠαράδειγμα', $lowerCamelCase);
    }

    public function testScreamingSnakeCase()
    {
        $screamingSnakeCase = TextCase::toScreamingSnake($this->_text);
        $this->assertEquals('HELLO_WORLD_NUMBERS_1_TO_10_AND_SOME_UNICODE_CHARS_ΓΕΙΆ_ΑΥΤΌ_ΕΊΝΑΙ_ΠΑΡΆΔΕΙΓΜΑ', $screamingSnakeCase);
    }

    public function testSnakeCase()
    {
        $snakeCase = TextCase::toSnake($this->_text);
        $this->assertEquals('hello_world_numbers_1_to_10_and_some_unicode_chars_γειά_αυτό_είναι_παράδειγμα', $snakeCase);
    }

    public function testTrainCase()
    {
        $trainCase = TextCase::toTrain($this->_text);
        $this->assertEquals('HELLO-WORLD-NUMBERS-1-TO-10-AND-SOME-UNICODE-CHARS-ΓΕΙΆ-ΑΥΤΌ-ΕΊΝΑΙ-ΠΑΡΆΔΕΙΓΜΑ', $trainCase);
    }

    public function testUpperCamelCase()
    {
        $upperCamelCase = TextCase::toUpperCamel($this->_text);
        $this->assertEquals('HelloWorldNumbers1To10AndSomeUnicodeCharsΓειάΑυτόΕίναιΠαράδειγμα', $upperCamelCase);
    }
}
