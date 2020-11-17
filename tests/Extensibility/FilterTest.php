<?php

namespace AntonioKadid\WAPPKitCore\Tests\Extensibility;

use AntonioKadid\WAPPKitCore\Extensibility\Filter;
use PHPUnit\Framework\TestCase;

final class FilterTest extends TestCase
{
    public function testApply()
    {
        $uniqueRef1 = Filter::registry()->add('sample_filter', function(string $value) { return strtoupper($value); });
        $uniqueRef2 = Filter::registry()->add('sample_filter', function(string $value) { return sprintf('%s from second filter.', $value); });

        $result = Filter::apply('sample_filter', 'hello');

        $this->assertEquals('HELLO from second filter.', $result);

        Filter::registry()->remove($uniqueRef1);
        Filter::registry()->remove($uniqueRef2);
    }
}
