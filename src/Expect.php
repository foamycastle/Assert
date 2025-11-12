<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   22:24
*/


namespace Foamycastle;

class Expect
{
    private static string $exceptionClassName;
    private static string $errorClassName;

    /**
     * Sets the expectation during runtime that an exception will occur during the very next assertion
     * @param string $className if `className` is blank, the function indicates if the expectation is set.  If the `className`
     * is supplied, the expectation is set with the given class name.
     * @return bool `TRUE` is the expectation is set
     */
    public static function Exception(string $className = ""): bool
    {
        if ($className != "") {
            self::$exceptionClassName = $className;
            return true;
        }
        return isset(self::$exceptionClassName);
    }

    /**
     * Sets the expectation during runtime that an exception will occur during the very next assertion
     * @param string $className if `className` is blank, the function indicates if the expectation is set.  If the `className`
     * is supplied, the expectation is set with the given class name.
     * @return bool `TRUE` is the expectation is set
     */
    public static function Error(string $className = ""): bool
    {
        if ($className != "") {
            self::$errorClassName = $className;
            return true;
        }
        return isset(self::$errorClassName);
    }

    /**
     * Clear all expectation flags
     * @return void true
     */
    public static function Nothing(): void
    {
        self::$exceptionClassName = "";
        self::$errorClassName = "";
    }

    /**
     * Reveal the class that is expected to throw an exception during the next assertion
     * @return string
     */
    public static function Get(): string
    {
        return self::$exceptionClassName;
    }
}