<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   20:25
*/


namespace Foamycastle;

interface AssertionGetInterface
{
    function getName(): string;

    function getMetadata(): MetadataInterface;

    function getParamNames(): array;

    function getParamValues(): array;

}