<?php

namespace AntonioKadid\WAPPKitCore\Tests\Text;

use AntonioKadid\WAPPKitCore\Text\KebabCase;
use PHPUnit\Framework\TestCase;

class KebabCaseTest extends TestCase
{
    public function testToKebabCase()
    {
        $kebabCase = new KebabCase();
        $kebabCase->load('Test kebab-Case');

        $this->assertEquals('test-kebab-case', $kebabCase->toKebabCase());
    }

    public function testToScreamingKebabCase()
    {
        $kebabCase = new KebabCase();
        $kebabCase->load('test Screaming kebab case');

        $this->assertEquals('TEST-SCREAMING-KEBAB-CASE', $kebabCase->toScreamingKebabCase());
    }

    public function testToTrainCase()
    {
        $kebabCase = new KebabCase();
        $kebabCase->load('test@-train@-case@');

        $this->assertEquals('Test-Train-Case', $kebabCase->toTrainCaseCase());
    }
}
