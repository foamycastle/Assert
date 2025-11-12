<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   10:26
*/


namespace Foamycastle;

interface ResultCollectionInterface
{
    function findByName(string $name): self;

    function findByResultType(string $resultClass): self;

    function findByMetaData(string $key, string $value): self;

    function getSearchResults(): array;
}