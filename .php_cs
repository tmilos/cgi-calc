<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('src')
;

$header = <<<EOT
This file is part of the CGI-Calc package.

(c) Milos Tomic <tmilos@gmail.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOT;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->setUsingCache(false)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array('-empty_return', '-phpdoc_no_empty_return', 'header_comment'))
    ->finder($finder)
;
