<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   15:29
*/


namespace Foamycastle;

interface FixtureAccess
{
    function getFixtureNames(): array;

    function hasFixture(string $name): bool;

    function getFixture(string $index): mixed;
}