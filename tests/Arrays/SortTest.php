<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests\Arrays;

use function PHPUnit\Framework\assertEquals;

use AntonioKadid\WAPPKitCore\Arrays\Sort;
use PHPUnit\Framework\TestCase;

final class SortTest extends TestCase
{
    public function testSort()
    {
        $array = [
            'variable',
            'century',
            'mystery',
            'decline',
            'jurisdiction',
        ];

        Sort::array($array)
            ->asc(function(string $item) { return $item; })
            ->go();

        assertEquals([
            'century',
            'decline',
            'jurisdiction',
            'mystery',
            'variable',
        ], $array);

        Sort::array($array)
            ->desc(function(string $item) { return $item; })
            ->go();

        assertEquals([
            'variable',
            'mystery',
            'jurisdiction',
            'decline',
            'century',
        ], $array);
    }
}