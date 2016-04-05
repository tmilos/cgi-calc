<?php

namespace Cgi\Calc\Tests\Field;

use Cgi\Calc\Field\CircularCenterRadius;
use Cgi\Calc\Field\RectangularFromTwoPoints;
use Cgi\Calc\Point;
use Cgi\Calc\PointSet;

class CircularCenterRadiusTest extends \PHPUnit_Framework_TestCase
{
    public function test_draw()
    {
        $circularProducer = new CircularCenterRadius(new Point(15,15), 10, true);
        $circle = $circularProducer->produce();

        $circle->smallestRectangularEnvelope();
        $rectangularProducer = new RectangularFromTwoPoints(new Point(0,0), new Point(30, 30));
        $rect = $rectangularProducer->produce();

        if (false) {
            $this->doDraw($circle, $rect);
        }

        static::assertFalse($circle->contains(new Point(11, 5)));
        static::assertTrue($circle->contains(new Point(12, 5)));

        static::assertTrue($circle->contains(new Point(15, 15)));

        static::assertTrue($circle->contains(new Point(15, 5)));
        static::assertTrue($circle->contains(new Point(15, 25)));

        static::assertTrue($circle->contains(new Point(5, 15)));
        static::assertTrue($circle->contains(new Point(25, 15)));
    }

    private function doDraw(PointSet $circle, PointSet $rect)
    {
        $arr = [];
        /** @var Point $point */
        foreach ($rect as $point) {
            $arr[$point->getY()][$point->getX()] = '.';
        }
        foreach ($circle as $point) {
            $arr[$point->getY()][$point->getX()] = 'X';
        }

        print "\n\n\n\n";
        $firstLine = true;
        for ($y=0, $yMax = count($arr); $y<$yMax; $y++) {
            $row = $arr[$y];
            if ($firstLine) {
                $firstLine = false;
                print 'y  ';
                for ($x=0, $xMax = count($row); $x<$xMax; $x++) {
                    print $x % 10;
                }
                print " x \n";
            }
            print str_pad($y, 3);
            for ($x=0, $xMax = count($row); $x<$xMax; $x++) {
                print $row[$x];
            }
            print "\n";
        }
        print "\n\n\n\n";
    }
}
