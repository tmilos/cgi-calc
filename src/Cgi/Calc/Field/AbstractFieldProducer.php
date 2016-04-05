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

use Cgi\Calc\FieldProducer;
use Cgi\Calc\Point;

abstract class AbstractFieldProducer implements FieldProducer
{
    private $callback;

    public function __construct($valueProvider)
    {
        $this->callback = $this->getValueCallable($valueProvider);
    }

    /**
     * @param Point $point
     *
     * @return mixed|null
     */
    protected function getValue(Point $point)
    {
        return $this->callback ? call_user_func($this->callback, $point) : null;
    }

    /**
     * @param ValueProvider|callable|null $valueProvider
     *
     * @return callable|null
     */
    private function getValueCallable($valueProvider)
    {
        $callback = null;
        if ($valueProvider instanceof ValueProvider) {
            $callback = function (Point $p) use ($valueProvider) {
                return $valueProvider->get($p);
            };
        } elseif (is_callable($valueProvider)) {
            $callback = $valueProvider;
        } elseif ($valueProvider) {
            throw new \InvalidArgumentException('Value provider must be instance of ValueProvider or callable');
        }

        return $callback;
    }
}
