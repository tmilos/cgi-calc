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

use Cgi\Calc\Point\PointSet;

interface FieldProducer
{
    /**
     * @return PointSet
     */
    public function produce();
}
