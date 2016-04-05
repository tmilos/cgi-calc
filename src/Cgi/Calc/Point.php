<?php

/*
 * This file is part of the CGI-Calc package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cgi\Calc;

class Point
{
    private static $delimiter = '|';

    /** @var int|float */
    private $x;

    /** @var int|float */
    private $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        if (false === is_numeric($x) || false === is_numeric($y)) {
            throw new \InvalidArgumentException('Number expected');
        }
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param string $hash
     *
     * @return Point
     */
    public static function parse($hash)
    {
        $arr = explode(static::$delimiter, $hash);

        return new self($arr[0], $arr[1]);
    }

    /**
     * @return string
     */
    public function hash()
    {
        return sprintf('%s%s%s', $this->getX(), static::$delimiter, $this->getY());
    }

    /**
     * @return int|float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int|float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return int|float
     */
    public function length()
    {
        return abs($this->getX()) + abs($this->getY());
    }

    /**
     * @return float
     */
    public function distance()
    {
        return sqrt($this->getX() * $this->getX() + $this->getY() * $this->getY());
    }

    /**
     * @return Point
     */
    public function left()
    {
        return new self($this->getX() - 1, $this->getY());
    }

    /**
     * @return Point
     */
    public function right()
    {
        return new self($this->getX() + 1, $this->getY());
    }

    /**
     * @return Point
     */
    public function up()
    {
        return new self($this->getX(), $this->getY() + 1);
    }

    /**
     * @return Point
     */
    public function down()
    {
        return new self($this->getX(), $this->getY() - 1);
    }

    /**
     * @param Point $by
     *
     * @return Point
     */
    public function move(Point $by)
    {
        return new self($this->getX() + $by->getX(), $this->getY() + $by->getY());
    }

    /**
     * @param Point $of
     *
     * @return bool
     */
    public function isLeft(Point $of)
    {
        return $this->getX() < $of->getX();
    }

    /**
     * @param Point $of
     *
     * @return bool
     */
    public function isRight(Point $of)
    {
        return $this->getX() > $of->getX();
    }

    /**
     * @param Point $of
     *
     * @return bool
     */
    public function isAbove(Point $of)
    {
        return $this->getY() > $of->getY();
    }

    /**
     * @param Point $of
     *
     * @return bool
     */
    public function isBelow(Point $of)
    {
        return $this->getY() < $of->getY();
    }

    /**
     * @param Point $as
     *
     * @return bool
     */
    public function sameX(Point $as)
    {
        return $this->getX() === $as->getX();
    }

    /**
     * @param Point $as
     *
     * @return bool
     */
    public function sameY(Point $as)
    {
        return $this->getY() === $as->getY();
    }

    /**
     * @param Point $other
     *
     * @return bool
     */
    public function equals(Point $other)
    {
        return $this->x === $other->getX() && $this->y === $other->getY();
    }

    /**
     * @param Point $a
     * @param Point $b
     *
     * @return bool
     */
    public function betweenX(Point $a, Point $b)
    {
        return $a->getX() <= $this->getX() && $this->getX() < $b->getX();
    }

    /**
     * @param Point $a
     * @param Point $b
     *
     * @return bool
     */
    public function betweenY(Point $a, Point $b)
    {
        return $a->getY() <= $this->getY() && $this->getY() < $b->getY();
    }

    /**
     * @param Point|int $upTo
     * @param int|float $step
     *
     * @return \Traversable
     */
    public function forXUpTo($upTo, $step = 1)
    {
        if ($upTo instanceof self) {
            $upTo = $upTo->getX();
        } elseif (false === is_int($upTo)) {
            throw new \InvalidArgumentException('UpTo argument must be Point or integer');
        }

        for ($x = $this->getX(); $x <= $upTo; $x += $step) {
            yield $x;
        }
    }

    /**
     * @param Point|int $upTo
     * @param int|float $step
     *
     * @return \Traversable
     */
    public function forYUpTo($upTo, $step = 1)
    {
        if ($upTo instanceof self) {
            $upTo = $upTo->getY();
        } elseif (false === is_int($upTo)) {
            throw new \InvalidArgumentException('UpTo argument must be Point or integer');
        }

        for ($y = $this->getY(); $y <= $upTo; $y += $step) {
            yield $y;
        }
    }

    /**
     * @param int $count
     *
     * @return \Traversable
     */
    public function forXTimes($count)
    {
        if (false === is_int($count)) {
            throw new \InvalidArgumentException('Count argument must be integer');
        }

        foreach ($this->forXUpTo($this->getX() + $count - 1) as $x) {
            yield $x;
        }
    }

    /**
     * @param int $count
     *
     * @return \Traversable
     */
    public function forYTimes($count)
    {
        if (false === is_int($count)) {
            throw new \InvalidArgumentException('Count argument must be integer');
        }

        foreach ($this->forYUpTo($this->getY() + $count - 1) as $y) {
            yield $y;
        }
    }
}
