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

class RectangularFromPointWidthHeight extends AbstractFieldProducer
{
    /** @var Point */
    private $lowerLeft;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    /**
     * @param Point                  $lowerLeft
     * @param int                    $width
     * @param int                    $height
     * @param ValueProvider|callable $valueProvider
     */
    public function __construct(Point $lowerLeft, $width, $height, $valueProvider = null)
    {
        parent::__construct($valueProvider);

        if (false === is_int($width) || false === is_int($height) || $width < 0 || $height < 0) {
            throw new \InvalidArgumentException('Width and height must be integers');
        }

        $this->lowerLeft = $lowerLeft;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return PointSet
     */
    public function produce()
    {
        $result = new PointSet();
        foreach ($this->lowerLeft->forXTimes($this->width) as $x) {
            foreach ($this->lowerLeft->forYTimes($this->height) as $y) {
                $point = new Point($x, $y);
                $value = $this->getValue($point);
                $result->attach($point, $value);
            }
        }

        return $result;
    }
}
