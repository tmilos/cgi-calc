<?php

/*
 * This file is part of the CGI-Calc package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cgi\Calc\Field;

use Cgi\Calc\Point;
use Cgi\Calc\Point\PointSet;

class CircularCenterRadius extends AbstractFieldProducer
{
    /** @var Point */
    private $center;

    /** @var int */
    private $radius;

    /** @var bool */
    private $fill;

    /**
     * @param Point                  $center
     * @param int                    $radius
     * @param ValueProvider|callable $valueProvider
     */
    public function __construct(Point $center, $radius, $fill, $valueProvider = null)
    {
        parent::__construct($valueProvider);

        if (false === is_int($radius) || $radius < 0) {
            throw new \InvalidArgumentException('Radius must be non-negative integer');
        }

        $this->center = $center;
        $this->radius = $radius;
        $this->fill = (bool) $fill;
    }

    /**
     * @return PointSet
     */
    public function produce()
    {
        /*
         * Bressenham's Midpoint Circle algorithm
         * http://stackoverflow.com/questions/1022178/how-to-make-a-circle-on-a-grid
         * http://rosettacode.org/wiki/Bitmap/Midpoint_circle_algorithm
         */
        $d = 3 - (2 * $this->radius);
        $x = 0;
        $y = $this->radius;

        $result = new PointSet();
        do {
            $this->addRow(
                $result,
                new Point($this->center->getX() + $x, $this->center->getY() + $y),
                new Point($this->center->getX() - $x, $this->center->getY() + $y)
            );

            $this->addRow(
                $result,
                new Point($this->center->getX() - $x, $this->center->getY() - $y),
                new Point($this->center->getX() + $x, $this->center->getY() - $y)
            );

            $this->addRow(
                $result,
                new Point($this->center->getX() - $y, $this->center->getY() + $x),
                new Point($this->center->getX() + $y, $this->center->getY() + $x)
            );

            $this->addRow(
                $result,
                new Point($this->center->getX() - $y, $this->center->getY() - $x),
                new Point($this->center->getX() + $y, $this->center->getY() - $x)
            );

            if ($d < 0) {
                $d = $d + (4 * $x) + 6;
            } else {
                $d = $d + 4 * ($x - $y) + 10;
                --$y;
            }
            ++$x;
        } while ($x <= $y);

        return $result;
    }

    /**
     * @param PointSet $result
     * @param Point    $a
     * @param Point    $b
     */
    private function addRow(PointSet $result, Point $a, Point $b)
    {
        if ($a->getX() > $b->getX()) {
            $t = $a;
            $a = $b;
            $b = $t;
        }
        if ($this->fill) {
            foreach ($a->forXUpTo($b) as $x) {
                $this->addPoint($result, new Point($x, $a->getY()));
            }
        } else {
            $this->addPoint($result, $a);
            $this->addPoint($result, $b);
        }
    }

    /**
     * @param PointSet $result
     * @param Point    $point
     */
    private function addPoint(PointSet $result, Point $point)
    {
        $value = $this->getValue($point);
        $result->attach($point, $value);
    }
}
