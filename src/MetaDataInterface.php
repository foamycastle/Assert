<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   16:25
*/


namespace Foamycastle;

use Countable;
use ArrayAccess;
use IteratorAggregate;

interface MetaDataInterface extends ArrayAccess, IteratorAggregate, Countable
{
    function clearKey(string $key): self;

    function setValue(string $key, mixed $value): self;

    function hasKey(string $key): bool;

    function isReadOnly(bool $readOnly): bool;

}