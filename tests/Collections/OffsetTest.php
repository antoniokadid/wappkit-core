<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests\Collections;

use AntonioKadid\WAPPKitCore\Collections\Offset;
use AntonioKadid\WAPPKitCore\Data\Value;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertArrayNotHasKey;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertTrue;
use PHPUnit\Framework\TestCase;

final class OffsetTest extends TestCase
{
    public function testOffsetExists()
    {
        $array  = $this->getTemplateArray();
        $offset = new Offset($array);

        assertTrue(Offset::exists($array, 'hello/world/this'));
        assertFalse(Offset::exists($array, 'random/offset/check'));

        assertArrayHasKey('hello/world/this', $offset);
        assertArrayNotHasKey('random/offset/check', $offset);
    }

    public function testValueGet()
    {
        $array = $this->getTemplateArray();

        $offset = new Offset($array);
        $value  = $offset['hello/world/this/is/an/example'];

        assertTrue(is_a($value, Value::class));
        assertEquals('The text or the value', $value->getString('default string'));

        $value = Offset::get($array, 'hello/world/this/is/an/exa');
        assertTrue(is_a($value, Value::class));
        assertEquals('default string', $value->getString('default string'));

        $value = Offset::get($array, 'whatever/in/here');
        assertTrue(is_a($value, Value::class));
        assertEquals('whatever string', $value->getString('whatever string'));
    }

    public function testValueSet()
    {
        $array = $this->getTemplateArray();

        Offset::set($array, 'hel\/lo/world', 'Replaced array with string.');

        assertArrayHasKey('hel\/lo', $array);
        assertArrayHasKey('world', $array['hel\/lo']);
        assertFalse(is_array($array['hel\/lo']['world']));
        assertEquals('Replaced array with string.', $array['hel\/lo']['world']);

        $array = [];

        $offset                      = new Offset($array);
        $offset['random/path/value'] = 'Text';

        assertArrayHasKey('random', $array);
        assertIsArray($array['random']);
        assertArrayHasKey('path', $array['random']);
        assertIsArray($array['random']['path']);
        assertArrayHasKey('value', $array['random']['path']);
        assertEquals('Text', $array['random']['path']['value']);

        $array = [
            'step1' => [
                'step2' => 5
            ]
        ];

        $random = rand(0, 100);

        Offset::set($array, 'step1/step2/step3', $random);

        assertArrayHasKey('step1', $array);
        assertIsArray($array['step1']);
        assertArrayHasKey('step2', $array['step1']);
        assertIsArray($array['step1']['step2']);
        assertEquals(2, count($array['step1']['step2']));
        assertEquals(5, $array['step1']['step2'][0]);
        assertArrayHasKey('step3', $array['step1']['step2']);
        assertEquals($random, $array['step1']['step2']['step3']);
    }

    public function testValueUnset()
    {
        $array = $this->getTemplateArray();

        Offset::unset($array, 'hello/world/this');

        assertArrayHasKey('hello', $array);
        assertArrayHasKey('world', $array['hello']);
        assertTrue(is_array($array['hello']['world']));
        assertEquals(0, count($array['hello']['world']));

        $array  = $this->getTemplateArray();
        $offset = new Offset($array);

        unset($offset['hello/world/this']);

        assertArrayHasKey('hello', $array);
        assertArrayHasKey('world', $array['hello']);
        assertTrue(is_array($array['hello']['world']));
        assertEquals(0, count($array['hello']['world']));

        $array = $this->getTemplateArray();

        Offset::unset($array, 'hello/whatever/this');

        assertArrayHasKey('hello', $array);
        assertArrayHasKey('world', $array['hello']);
        assertTrue(is_array($array['hello']['world']));
        assertEquals(1, count($array['hello']['world']));
    }

    private function getTemplateArray(): array {
        return [
            'hello' => [
                'world' => [
                    'this' => [
                        'is' => [
                            'an' => [
                                'example' => 'The text or the value'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
