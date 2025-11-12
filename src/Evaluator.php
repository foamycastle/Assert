<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   0:24
*/


namespace Foamycastle;

abstract class Evaluator
{
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

}