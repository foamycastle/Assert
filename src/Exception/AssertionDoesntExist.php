<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   15:42
*/


namespace Foamycastle\Exception;

use Exception;

class AssertionDoesntExist extends Exception
{
    public function __construct(string $badMethod)
    {
        parent::__construct("The assertion method '$badMethod' does not exist.");
    }
}