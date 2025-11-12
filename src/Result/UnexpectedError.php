<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   23:03
*/


namespace Foamycastle\Result;

use Foamycastle\Result;
use Foamycastle\Assert;

class UnexpectedError extends Result
{
    protected function __construct(Assert $assertion)
    {
        parent::__construct($assertion);
    }

    public function result(): bool
    {
        return false;
    }
}