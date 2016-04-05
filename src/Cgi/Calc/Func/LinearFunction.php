<?php

/*
 * This file is part of the CGI-Calc package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cgi\Calc\Func;

use Cgi\Calc\FunctionInterface;
use Cgi\Calc\Point;

class LinearFunction implements FunctionInterface
{
    /** @var float */
    private $k;

    /** @var float */
    private $n;

    /**
     * @param float $k
     * @param float $n
     */
    public function __construct($k, $n)
    {
        $this->k = $k;
        $this->n = $n;
    }

    /**
     * @param Point $a
     * @param Point $b
     *
     * @return LinearFunction
     *
     * @throws \RuntimeException When $a and $b points have same x
     */
    public static function fromTwoPoints(Point $a, Point $b)
    {
        if ($a->getX() === $b->getX()) {
            throw new \RuntimeException('Line can be defined only by two points with different X');
        }

        $k = ($a->getY() - $b->getY()) / ($a->getX() - $b->getX());
        $n = $a->getY() - $k * $a->getX();

        return new self($k, $n);
    }

    /**
     * @param float $x
     *
     * @return float
     */
    public function evaluate($x)
    {
        return $this->k * $x + $this->n;
    }
}
