<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   10:15
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;
use Foamycastle\MetaData\Key;

class IsFalse extends Assert
{
    private mixed $testFixture;
    private bool $strict;

    public function __construct(mixed $testFixture, bool $strict = true)
    {
        $this->testFixture = $testFixture;
        $this->strict = $strict;
        parent::__construct($this->testFixture);
    }

    /**
     * @inheritDoc
     */
    protected function assert(): bool
    {
        if (is_bool($this->testFixture)) {
            return !$this->testFixture;
        }
        //at this point, stricture would dictate that the evaluation is over.
        if ($this->strict) {
            return false;
        }
        if (is_callable($this->testFixture)) {
            $result = ($this->testFixture)(...);
        }
        if ($this->testFixture instanceof Closure) {
            $result = ($this->testFixture)();
        }
        if (isset($result) && is_bool($result)) {
            return !$result;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function metadata(): array
    {
        return [
            Key::NAME => "IsFalse",
            Key::DESC => "Assert that the test fixture evaluates to false"
        ];
    }
}