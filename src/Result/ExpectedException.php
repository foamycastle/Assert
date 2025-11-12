<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   22:49
*/


namespace Foamycastle\Result;

use Foamycastle\Result;
use Foamycastle\Assert;

class ExpectedException extends Result
{
    public function __construct(Assert $assertion)
    {
        parent::__construct($assertion);
    }

    public function result(): bool
    {
        return true;
    }
}