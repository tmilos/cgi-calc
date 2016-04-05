<?php

/*
 * This file is part of the CGI-Calc package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cgi\Calc\Point;

use Cgi\Calc\Func\LinearFunction;
use Cgi\Calc\Point;

class Line
{
    /** @var Point */
    private $startPoint;

    /** @var Point */
    private $endPoint;

    /**
     * @param Point $startPoint
     * @param Point $endPoint
     */
    public function __construct(Point $startPoint, Point $endPoint)
    {
        $this->startPoint = $startPoint;
        $this->endPoint = $endPoint;
    }

    /**
     * @param Point $a
     * @param Point $b
     *
     * @return Line
     */
    public static function combineToRisingLine(Point $a, Point $b)
    {
        $minX = min($a->getX(), $b->getX());
        $maxX = max($a->getX(), $b->getX());
        $minY = min($a->getY(), $b->getY());
        $maxY = max($a->getY(), $b->getY());

        return new self(new Point($minX, $minY), new Point($maxX, $maxY));
    }

    /**
     * @return Point
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * @return Point
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @return LinearFunction
     */
    public function getLinearFunction()
    {
        return LinearFunction::fromTwoPoints($this->startPoint, $this->endPoint);
    }
}
