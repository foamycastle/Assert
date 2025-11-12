<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   14:32
*/


namespace Foamycastle\Assert;

use ArrayAccess;
use Foamycastle\MetaData\Key;

/**
 * @property-read mixed $array
 */
class IsAnArray extends SingleFixture
{
    //properties here
    public function __construct(mixed $array)
    {
        //TODO: Assign properties
        parent::__construct($array);
    }

    /**
     * @inheritDoc
     */
    protected function assert(): bool
    {
        if (
            is_array($this->array) ||
            ($this->array instanceof ArrayAccess)
        ) return true;
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function metadata(): array
    {
        return [
            Key::NAME => 'IsAnArray',
            Key::DESC => 'The test fixture is a strongly-typed array',
        ];
    }
}