<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   15:03
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;
use ReflectionClass;

abstract class MultiFixture extends Assert
{
    protected function __construct(...$args)
    {
        $reflection = new ReflectionClass($this);
        $params = $reflection->getConstructor()->getParameters();
        $combine = array_combine(
            array_map(fn($param) => $param->getName(), $params),
            $args
        );
        parent::__construct($combine);
    }
}