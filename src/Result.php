<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:46
*/


namespace Foamycastle;

use Foamycastle\Result\NegativeResult;
use Foamycastle\Result\PositiveResult;

abstract class Result
{
    private AssertionGetInterface $assertion;

    protected function __construct(AssertionGetInterface $assertion)
    {
        $this->assertion = $assertion;
    }

    abstract public function result(): bool;

    public static function Pass(Assert $assertion): self
    {
        return new PositiveResult($assertion);
    }

    public static function Fail(Assert $assertion): self
    {
        return new NegativeResult($assertion);
    }


}