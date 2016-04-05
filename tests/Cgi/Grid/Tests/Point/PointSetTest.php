<?php

namespace Cgi\Calc\Tests\Point;

use Cgi\Calc\Point;
use Cgi\Calc\Point\PointSet;

class PointSetTest extends \PHPUnit_Framework_TestCase
{
    public function test_index_data_with_points()
    {
        $set = new PointSet();
        $set->attach($p11 = new Point(1,1), $v11 = 'v11');

        static::assertTrue($set->contains($p11));
        static::assertEquals($set[$p11], $v11);
    }

    public function test_union()
    {
        $a = new PointSet([new Point(1,1), new Point(2,2), new Point(3,3)]);
        $b = new PointSet([new Point(3,1), new Point(2,2), new Point(1,3)]);
        $r = $a->union($b);

        static::assertEquals(3, $a->count());
        static::assertEquals(3, $b->count());
        static::assertEquals(5, $r->count());
        static::assertNotSame($r, $a);
        static::assertNotSame($r, $b);

        foreach ($a as $point) {
            static::assertTrue($r->contains($point));
        }
        foreach ($b as $point) {
            static::assertTrue($r->contains($point));
        }
    }

    public function test_intersect()
    {
        $a = new PointSet([new Point(1,1), new Point(2,2), new Point(3,3)]);
        $b = new PointSet([new Point(3,1), new Point(2,2), new Point(1,3)]);
        $r = $a->intersect($b);

        static::assertEquals(3, $a->count());
        static::assertEquals(3, $b->count());
        static::assertEquals(1, $r->count());
        static::assertNotSame($r, $a);
        static::assertNotSame($r, $b);

        static::assertTrue($r->contains(new Point(2,2)));
    }

    public function test_diff()
    {
        $a = new PointSet([new Point(1,1), new Point(2,2), new Point(3,3)]);
        $b = new PointSet([new Point(3,1), new Point(2,2), new Point(1,3)]);
        $r = $a->diff($b);

        static::assertEquals(3, $a->count());
        static::assertEquals(3, $b->count());
        static::assertEquals(2, $r->count());
        static::assertNotSame($r, $a);
        static::assertNotSame($r, $b);

        static::assertTrue($r->contains(new Point(1,1)));
        static::assertTrue($r->contains(new Point(3,3)));
    }
}
