<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\FlatCase;
use PHPUnit\Framework\TestCase;

class FlatCaseTest extends TestCase
{
    public function testToFlatCase()
    {
        $flatCase = new FlatCase();

        $flatCase->load("Test\nFlat\nCase");
        $this->assertEquals('testflatcase', $flatCase->toFlatCase());

        $flatCase->load("Test\nFl@t\nc@se");
        $this->assertEquals('testfltcse', $flatCase->toFlatCase());

    }

    public function testToUpperFlatCase()
    {
        $camelCase = new FlatCase();
        $camelCase->load('test flat case');

        $this->assertEquals('TESTFLATCASE', $camelCase->toUpperFlatCase());
    }
}
