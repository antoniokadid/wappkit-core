<?php declare(strict_types=1);

namespace AntonioKadid\WAPPKitCore\Tests;

use AntonioKadid\WAPPKitCore\Flag;
use function PHPUnit\Framework\assertEquals;

use PHPUnit\Framework\TestCase;

class FlagTest extends TestCase
{
    public function testAdd()
    {
        $flag1 = 1;
        $flag2 = 2;
        $flag4 = 4;

        $flags = 0;

        $flags = Flag::add($flags, $flag2);
        assertEquals(2, $flags);

        $flags = Flag::add($flags, $flag4);
        assertEquals(6, $flags);

        $flags = Flag::add($flags, $flag1);
        assertEquals(7, $flags);
    }

    public function testExists() {
        $flag1 = 1;
        $flag2 = 2;
        $flag4 = 4;

        $flags = 0;

        $this->assertEquals(false, Flag::exists($flags, $flag1));
        $this->assertEquals(false, Flag::exists($flags, $flag2));
        $this->assertEquals(false, Flag::exists($flags, $flag4));

        $flags = 1;

        $this->assertEquals(true, Flag::exists($flags, $flag1));
        $this->assertEquals(false, Flag::exists($flags, $flag2));
        $this->assertEquals(false, Flag::exists($flags, $flag4));

        $flags = 2;

        $this->assertEquals(false, Flag::exists($flags, $flag1));
        $this->assertEquals(true, Flag::exists($flags, $flag2));
        $this->assertEquals(false, Flag::exists($flags, $flag4));

        $flags = 3;

        $this->assertEquals(true, Flag::exists($flags, $flag1));
        $this->assertEquals(true, Flag::exists($flags, $flag2));
        $this->assertEquals(false, Flag::exists($flags, $flag4));

        $flags = 4;

        $this->assertEquals(false, Flag::exists($flags, $flag1));
        $this->assertEquals(false, Flag::exists($flags, $flag2));
        $this->assertEquals(true, Flag::exists($flags, $flag4));

        $flags = 5;

        $this->assertEquals(true, Flag::exists($flags, $flag1));
        $this->assertEquals(false, Flag::exists($flags, $flag2));
        $this->assertEquals(true, Flag::exists($flags, $flag4));

        $flags = 6;

        $this->assertEquals(false, Flag::exists($flags, $flag1));
        $this->assertEquals(true, Flag::exists($flags, $flag2));
        $this->assertEquals(true, Flag::exists($flags, $flag4));

        $flags = 7;

        $this->assertEquals(true, Flag::exists($flags, $flag1));
        $this->assertEquals(true, Flag::exists($flags, $flag2));
        $this->assertEquals(true, Flag::exists($flags, $flag4));
    }

    public function testRemove()
    {
        $flag1 = 1;
        $flag2 = 2;
        $flag4 = 4;

        $flags = 7;

        $flags = Flag::remove($flags, $flag2);
        assertEquals(5, $flags);

        $flags = Flag::remove($flags, $flag4);
        assertEquals(1, $flags);

        $flags = Flag::remove($flags, $flag1);
        assertEquals(0, $flags);
    }
}
