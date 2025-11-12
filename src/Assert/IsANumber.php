<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   10:20
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;
use Foamycastle\MetaData\Key;

class IsANumber extends Assert
{

    private mixed $someData;

    protected function __construct(mixed $data)
    {
        $this->someData = $data;
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    protected function assert(): bool
    {
        return (
            is_int($this->someData) ||
            is_float($this->someData)
        );
    }

    /**
     * @inheritDoc
     */
    protected function metadata(): array
    {
        return [
            Key::NAME => "IsANumber",
            Key::DESC => "Assert that the test fixture is a number"
        ];
    }
}