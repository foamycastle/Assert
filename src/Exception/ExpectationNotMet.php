<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   23:21
*/


namespace Foamycastle\Exception;

use Exception;
use Foamycastle\Assert;
use Foamycastle\Expect;

class ExpectationNotMet extends Exception
{
    public function __construct(Assert $assertion)
    {
        $testName = $assertion->metadata['name'];
        $exceptionClass = Expect::Get();
        parent::__construct("Expectation that `{$testName}` throw the exception $exceptionClass was not met.");
    }
}