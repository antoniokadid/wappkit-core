<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests\Arrays;

use AntonioKadid\WAPPKitCore\Arrays\Group;

use function PHPUnit\Framework\assertEquals;
use PHPUnit\Framework\TestCase;

final class GroupTest extends TestCase
{
    public function testGroup()
    {
        $array = [
            ['name' => 'Name 1', 'country' => 'Cyprus', 'city' => 'Paphos'],
            ['name' => 'Name 2', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 3', 'country' => 'Cyprus', 'city' => 'Nicosia'],
            ['name' => 'Name 4', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 5', 'country' => 'Greece', 'city' => 'Athens'],
            ['name' => 'Name 6', 'country' => 'Greece', 'city' => 'Thessaloniki']
        ];

        Group::array($array)
            ->by(function(array $item) { return $item['country']; })
            ->by(function(array $item) { return $item['city']; })
            ->go();

        assertEquals([
            'Cyprus' => [
                'Paphos' => [
                    ['name' => 'Name 1', 'country' => 'Cyprus', 'city' => 'Paphos']
                ],
                'Nicosia' => [
                    ['name' => 'Name 2', 'country' => 'Cyprus', 'city' => 'Nicosia'],
                    ['name' => 'Name 3', 'country' => 'Cyprus', 'city' => 'Nicosia']
                ]
            ],
            'Greece' => [
                'Athens' => [
                    ['name' => 'Name 4', 'country' => 'Greece', 'city' => 'Athens'],
                    ['name' => 'Name 5', 'country' => 'Greece', 'city' => 'Athens']
                ],
                'Thessaloniki' => [
                    ['name' => 'Name 6', 'country' => 'Greece', 'city' => 'Thessaloniki']
                ]
            ]
        ], $array);
    }
}
