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
use Cgi\Calc\Point\Path;
use Cgi\Calc\Point;

class IntervalFunction implements FunctionInterface
{
    /** @var Path */
    private $path;

    /** @var bool */
    private $extrapolate;

    /**
     * @param Path $path
     * @param bool $extrapolate
     */
    public function __construct(Path $path, $extrapolate = true)
    {
        if (false === $path->isMonotonouslyIncreasingX()) {
            throw new \InvalidArgumentException('Path must be monotony increasing by X');
        }

        $this->path = $path;
        $this->extrapolate = $extrapolate ? true : false;
    }

    /**
     * @param float $x
     *
     * @return float|null
     */
    public function evaluate($x)
    {
        $nowPoint = new Point($x, 0);

        $containingLine = null;
        foreach ($this->path->getLineIterator() as $line) {
            if ($nowPoint->betweenX($line->getStartPoint(), $line->getEndPoint())) {
                $containingLine = $line;
                break;
            }
        }

        if (null === $containingLine) {
            if (false === $this->extrapolate) {
                return null;
            }

            if ($this->path->firstPoint()->getX() > $x) {
                $containingLine = $this->path->firstLine();
            } else {
                $containingLine = $this->path->lastLine();
            }
        }

        return $containingLine->getLinearFunction()->evaluate($x);
    }
}
