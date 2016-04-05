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

use Cgi\Calc\Point;

class Path implements \Countable
{
    /** @var Point[] */
    private $points;

    /**
     * @param Point[] $points
     */
    public function __construct(array $points)
    {
        $this->points = [];
        foreach ($points as $point) {
            if ($point instanceof Point) {
                $this->points[] = $point;
            } else {
                throw new \InvalidArgumentException('Expected instance of Point class');
            }
        }
    }

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return bool
     */
    public function isMonotonouslyIncreasingX()
    {
        return count($this->points) > 1 && $this->getMonotony($this->getAllX()) === 1;
    }

    /**
     * @return bool
     */
    public function isMonotonouslyIncreasingY()
    {
        return count($this->points) > 1 && $this->getMonotony($this->getAllY()) === 1;
    }

    /**
     * @return int|float[]
     */
    public function getAllX()
    {
        return array_map(function (Point $p) {
            return $p->getX();
        }, $this->points);
    }

    /**
     * @return int|float[]
     */
    public function getAllY()
    {
        return array_map(function (Point $p) {
            return $p->getY();
        }, $this->points);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->points);
    }

    /**
     * @return Point|null
     */
    public function firstPoint()
    {
        return reset($this->points);
    }

    /**
     * @return Point|null
     */
    public function lastPoint()
    {
        return end($this->points);
    }

    /**
     * @return Line
     */
    public function firstLine()
    {
        return new Line($this->points[0], $this->points[1]);
    }

    public function lastLine()
    {
        $count = count($this->points);

        return new Line($this->points[$count - 2], $this->points[$count - 1]);
    }

    /**
     * @return LineIterator
     */
    public function getLineIterator()
    {
        return new LineIterator($this);
    }

    /**
     * @return \ArrayIterator
     */
    public function getPointIterator()
    {
        return new \ArrayIterator($this->points);
    }

    /**
     * @param int[] $arr
     *
     * @return int|null Null if not monotonous, -1 if monotony decreasing, +1 if monotony increasing
     */
    public function getMonotony(array $arr)
    {
        $count = 0;
        $previous = null;
        $sign = null; // 1 for increasing, -1 for decreasing
        foreach ($arr as $item) {
            ++$count;
            if (2 === $count) {
                $sign = $previous < $item ? 1 : -1; // is second element greater or smaller then first
            } elseif ($sign > 0 && $item < $previous) { // is still increasing
                return null;
            } elseif ($sign < 0 && $item > $previous) { // is still decreasing
                return null;
            }

            $previous = $item;
        }

        return $sign;
    }
}
