<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   20:48
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;

class HasClass extends Assert
{
    private string $className;
    private object $object;

    public function __construct(object $object, string $className)
    {
        $this->className = $className;
        $this->object = $object;
        parent::__construct($object, $className);
    }

    public function assert(): bool
    {
        return true;
    }
}