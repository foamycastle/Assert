<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   14:32
*/


namespace Foamycastle\Assert;

use Foamycastle\MetaData\Key;
use Stringable;

/**
 * @property-read mixed $string
 */
class IsAString extends SingleFixture
{
    //properties here
    public function __construct(mixed $string)
    {
        parent::__construct($string);
    }

    /**
     * @inheritDoc
     */
    protected function assert(): bool
    {
        if (
            is_string($this->string) ||
            ($this->string instanceof Stringable)
        ) return true;
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function metadata(): array
    {
        return [
            Key::NAME => 'IsAString',
            Key::DESC => 'test fixture is strongly-typed as a string ',
        ];
    }
}