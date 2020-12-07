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

        $array = [
            ['name' => 'Name 1', 'country' => 'Cyprus', 'city' => 'Paphos'],
            ['name' => 'Name 2', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 3', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 4', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 5', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 6', 'country' => 'Greece', 'city' => 'Thessaloniki']
        ];

        Sort::array($array)
            ->desc(function(array $item) { return $item['country']; })
            ->asc(function(array $item) { return $item['city']; })
            ->go();

        assertEquals([
            ['name' => 'Name 4', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 5', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 6', 'country' => 'Greece', 'city' => 'Thessaloniki'],
            ['name' => 'Name 2', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 3', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 1', 'country' => 'Cyprus', 'city' => 'Paphos'],
        ],$array);
    }
}