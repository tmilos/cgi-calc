<?php

namespace Cgi\Calc\Tests;

use Cgi\Calc\Point;

class PointTest extends \PHPUnit_Framework_TestCase
{
    public function test_constructs_with_two_integers()
    {
        new Point(1, 2);
    }

    public function test_constructs_with_two_floats()
    {
        new Point(1.2, 3.4);
    }

    public function test_length_is_sum_of_coordinates()
    {
        $point = new Point(5,8);
        static::assertEquals(13, $point->length());
    }

    public function test_distance_is_distance_from_the_origin()
    {
        $point = new Point(3,4);
        static::assertEquals(5, $point->distance());
    }

    public function test_move_returns_new_point()
    {
        $a = new Point(1,1);
        $c = $a->move($by = new Point(2,2));

        static::assertNotSame($a, $c);
        static::assertNotSame($by, $c);
    }
}
