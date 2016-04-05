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

class LineIterator implements \Iterator
{
    /** @var Point[] */
    private $points;

    /** @var int */
    private $index = 0;

    /**
     * @param Path $path
     */
    public function __construct(Path $path)
    {
        $this->points = $path->getPoints();
        $this->index = 0;
    }

    /**
     * @return Line
     */
    public function current()
    {
        return new Line($this->points[$this->index], $this->points[$this->index + 1]);
    }

    public function next()
    {
        ++$this->index;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->points[$this->index]) && isset($this->points[$this->index + 1]);
    }

    public function rewind()
    {
        $this->index = 0;
    }
}
