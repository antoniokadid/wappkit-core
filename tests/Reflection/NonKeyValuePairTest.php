<?php

namespace AntonioKadid\WAPPKitCore\Tests\Reflection;

use AntonioKadid\WAPPKitCore\Reflection\Injector;
use PHPUnit\Framework\TestCase;

class NonKeyValuePairTest extends TestCase
{
    public function testNonKeyValuePair()
    {
        $result = Injector::inject(
            fn (int $number, string $text, bool $value) => $value ? sprintf('%s_%d', $text, $number) : sprintf('%d_%s', $number, $text),
            [1, 'test', true]);

        $this->assertEquals('test_1', $result);

        $result = Injector::inject(
            fn (int $number, string $text, bool $value) => $value ? sprintf('%s_%d', $text, $number) : sprintf('%d_%s', $number, $text),
            [1, 'test', false]);

        $this->assertEquals('1_test', $result);

        $result = Injector::inject(
            fn (int $number, string $text, bool $value) => $value ? sprintf('%s_%d', $text, $number) : sprintf('%d_%s', $number, $text),
            [1, 'test']);
        $this->assertEquals('1_test', $result);
    }
}
