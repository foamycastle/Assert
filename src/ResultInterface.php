<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   10:32
*/


namespace Foamycastle;

interface ResultInterface
{
    /**
     * Expose the assertion object
     * @return Assert
     */
    function getAssertion(): Assert;
}