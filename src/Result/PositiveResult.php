<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:53
*/


namespace Foamycastle\Result;

use Foamycastle\Result;
use Foamycastle\AssertionGetInterface;

class PositiveResult extends Result
{
    public function __construct(AssertionGetInterface $assertion)
    {
        parent::__construct($assertion);
    }

    /**
     * @return bool
     */
    public function result(): bool
    {
        return true;
    }
}