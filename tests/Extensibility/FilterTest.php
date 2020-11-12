<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Extensibility\Filter;
use PHPUnit\Framework\TestCase;

final class FilterTest extends TestCase
{
    public function testApply()
    {
        $uniqueId = Filter::registry()->add('test-filter', function(string $value) { return strtoupper($value); });
        $uniqueId2 = Filter::registry()->add('test-filter', function(string $value) { return sprintf('%s from second filter.', $value); });

        $result = Filter::apply('test-filter', 'hello');

        $this->assertEquals('HELLO from second filter.', $result);

        Filter::registry()->remove('test-filter', $uniqueId);
        Filter::registry()->remove('test-filter', $uniqueId2);
    }
}
