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

class PointSet extends \SplObjectStorage
{
    /**
     * @param PointSet $other
     *
     * @return PointSet
     */
    public static function duplicate(PointSet $other)
    {
        $result = new self();
        $result->addAll($other);

        return $result;
    }

    /**
     * @param Point[] $points
     */
    public function __construct(array $points = [])
    {
        foreach ($points as $point) {
            if ($point instanceof Point) {
                $this->attach($point);
            } else {
                throw new \InvalidArgumentException('PointSet can index instances of Point only');
            }
        }
    }

    /**
     * @param PointSet $other
     *
     * @return PointSet
     */
    public function intersect(PointSet $other)
    {
        $result = new self();
        $result->addAll($this);
        $result->removeAllExcept($other);

        return $result;
    }

    /**
     * @param PointSet $other
     *
     * @return PointSet
     */
    public function union(PointSet $other)
    {
        $result = new self();
        $result->addAll($this);
        $result->addAll($other);

        return $result;
    }

    /**
     * @param PointSet $other
     *
     * @return PointSet
     */
    public function diff(PointSet $other)
    {
        $result = new self();
        $result->addAll($this);
        $result->removeAll($other);

        return $result;
    }

    public function getHash($object)
    {
        if ($object instanceof Point) {
            return $object->hash();
        }

        throw new \InvalidArgumentException('PointSet can index instances of Point only');
    }

    /**
     * @param callable $callback
     *
     * @return PointSet
     */
    public function map($callback)
    {
        $result = new self();
        foreach ($this as $point) {
            $value = $this[$point];
            if (call_user_func($callback, $point, $value)) {
                $result->attach($point, $value);
            }
        }

        return $result;
    }

    /**
     * @param callable $callback
     * @param mixed    $initial
     *
     * @return mixed
     */
    public function reduce($callback, $initial)
    {
        foreach ($this as $point) {
            $initial = call_user_func($callback, $point, $this[$point]);
        }

        return $initial;
    }

    /**
     * @return Line
     */
    public function smallestRectangularEnvelope()
    {
        $minX = $minY = $maxX = $maxY = null;
        /** @var Point $point */
        foreach ($this as $point) {
            if ($minX === null || $minX > $point->getX()) {
                $minX = $point->getX();
            }
            if ($minY === null || $minY > $point->getY()) {
                $minY = $point->getY();
            }
            if ($maxX === null || $maxX < $point->getX()) {
                $maxX = $point->getX();
            }
            if ($maxY === null || $maxY < $point->getY()) {
                $maxY = $point->getY();
            }
        }

        return new Line(new Point($minX, $minY), new Point($maxX, $maxY));
    }
}
