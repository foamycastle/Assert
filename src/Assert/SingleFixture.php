<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   14:55
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;
use ReflectionClass;

abstract class SingleFixture extends Assert
{
    public function __construct(mixed $fixture)
    {
        $reflect = new ReflectionClass($this);
        $paramName = $reflect->getConstructor()->getParameters()[0]->getName();
        parent::__construct([$paramName => $fixture]);
    }
}