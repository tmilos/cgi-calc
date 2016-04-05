<?php

namespace Cgi\Calc\Tests\Field;

use Cgi\Calc\Field\RectangularFromTwoPoints;
use Cgi\Calc\Point;

class RectangularFromTwoPointsTest extends \PHPUnit_Framework_TestCase
{
    public function count_provider()
    {
        return [
            [new Point(1,1), new Point(1, 1), 1],
            [new Point(1,1), new Point(2, 2), 4],
            [new Point(1,1), new Point(3, 3), 9],

            [new Point(1,1), new Point(4, 3), 12],
        ];
    }

    /**
     * @dataProvider count_provider
     */
    public function test_count(Point $lowerLeft, Point $upperRight, $expectedCount)
    {
        $producer = new RectangularFromTwoPoints($lowerLeft, $upperRight);
        $field = $producer->produce();

        $actualCount = $field->count();
        static::assertEquals($expectedCount, $actualCount);
    }

    public function point_belongs_to_rectangular_provider()
    {
        return [
            [new Point(1,1), new Point(4, 3), new Point(1,1), true],
            [new Point(1,1), new Point(4, 3), new Point(2,2), true],
            [new Point(1,1), new Point(4, 3), new Point(3,3), true],
            [new Point(1,1), new Point(4, 3), new Point(4,3), true],

            [new Point(1,1), new Point(4, 3), new Point(0,0), false],
            [new Point(1,1), new Point(4, 3), new Point(0,4), false],
            [new Point(1,1), new Point(4, 3), new Point(4,4), false],
            [new Point(1,1), new Point(4, 3), new Point(4,0), false],
        ];
    }

    /**
     * @dataProvider point_belongs_to_rectangular_provider
     */
    public function test_point_belongs_to_rectangular(Point $lowerLeft, Point $upperRight, Point $testPoint, $expectedIn)
    {
        $producer = new RectangularFromTwoPoints($lowerLeft, $upperRight);
        $field = $producer->produce();

        $actualIn = $field->contains($testPoint);
        static::assertEquals($expectedIn, $actualIn);
    }
}
