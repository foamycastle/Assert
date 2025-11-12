<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   14:32
*/


namespace Foamycastle\Assert;

use Foamycastle\MetaData\Key;

/**
 * @property-read mixed $bool
 */
class IsABool extends SingleFixture
{
    //properties here
    public function __construct(mixed $bool)
    {
        //TODO: Assign properties
        parent::__construct($bool);
    }

    /**
     * @inheritDoc
     */
    protected function assert(): bool
    {
        if (
            is_bool($this->bool)
        ) return true;
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function metadata(): array
    {
        return [
            Key::NAME => 'IsABool',
            Key::DESC => 'Test fixture is a strongly-type boolean',
        ];
    }
}