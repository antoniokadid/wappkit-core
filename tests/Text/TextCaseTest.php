<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\CamelCase;
use AntonioKadid\WAPPKitCore\Text\SnakeCase;
use PHPUnit\Framework\TestCase;

class TextCaseTest extends TestCase
{
    public function testLoadFromTextCase()
    {
        $snakeCase = new SnakeCase();
        $snakeCase->load('this_is_snake_case_input');

        $camelCase = new CamelCase();
        $camelCase->loadFromTextCase($snakeCase);

        $this->assertEquals('ThisIsSnakeCaseInput', $camelCase->toUpperCamelCase());
    }
}
