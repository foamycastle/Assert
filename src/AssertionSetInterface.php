<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   16:09
*/


namespace Foamycastle;

interface AssertionSetInterface
{
    /**
     * Provide a name for the assertion procedure for the purposes of reporting.
     * @param string $name the name of the assertion procedure
     * @return self
     */
    function setName(string $name): self;

    /**
     * Set or get meta for the assertion procedure
     * @param string $key the metadata key
     * @param mixed $value the value to set
     * @return array|scalar|null|MetaDataInterface If both `$key` and `$value` are empty, the `MetaDataInterface` is returned.
     *  If the `$key` is present, the value for that key is return if it is set, otherwise null is returned.
     *  If both `$key` and `$value` are present, the `$value` is set for that `$key`.  In this scenario, the setter is fluid.
     */
    function metadata(string $key, $value): mixed;
}