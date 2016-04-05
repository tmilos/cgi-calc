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

class RectangularFromTwoPoints extends AbstractFieldProducer
{
    /** @var Point */
    private $lowerLeft;

    /** @var Point */
    private $upperRight;

    /**
     * @param Point                  $lowerLeft
     * @param Point                  $upperRight
     * @param ValueProvider|callable $valueProvider
     */
    public function __construct(Point $lowerLeft, Point $upperRight, $valueProvider = null)
    {
        parent::__construct($valueProvider);

        if ($lowerLeft->isRight($upperRight) || $lowerLeft->isAbove($upperRight)) {
            throw new \InvalidArgumentException('First point must not be right or above of the second point');
        }

        $this->lowerLeft = $lowerLeft;
        $this->upperRight = $upperRight;
    }

    /**
     * @return PointSet
     */
    public function produce()
    {
        $result = new PointSet();
        foreach ($this->lowerLeft->forXUpTo($this->upperRight) as $x) {
            foreach ($this->lowerLeft->forYUpTo($this->upperRight) as $y) {
                $point = new Point($x, $y);
                $value = $this->getValue($point);
                $result->attach($point, $value);
            }
        }

        return $result;
    }
}
