<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:43
*/


namespace Foamycastle;

use ReflectionFunction;

abstract class Assert
{
    /**
     * The result of the assertion procedure logic
     * @var Result
     */
    protected Result $result;

    /**
     * data that is not germaine to the procedure, but may have generated during the procedure that is relevant elsewhere
     * @var array
     */
    public MetaDataInterface $metadata;

    /**
     * The actual procedure
     * @return bool
     */
    abstract protected function assert(): bool;

    /**
     * @return array various metadata pertaining to the test itself
     */
    abstract protected function metadata(): array;

    protected function __construct(...$args)
    {
        $this->metadata = new MetaData();
        $this->metadata->ingest($this->metadata());
        $this->metadata['params'] = $args;
        $this->getReflection();
        $this->initTest();

        Result::Collect($this->result);
    }

    protected function initTest(): void
    {
        $this->result = $this->assert() ? Result::Pass($this) : Result::Fail($this);
    }
    protected function getReflection(): void
    {

        $this->metadata['procedure'] = new ReflectionFunction($this->__construct(...));
        $this->metadata['paramNames'] = $this->metadata['procedure']->getParameters();
    }


    public static function __callStatic(string $name, array $arguments)
    {
        $ns = __NAMESPACE__ . '\\' . "Assert" . "\\" . $name;
        if (class_exists($ns)) {
            return new $ns(...$arguments);
        } else {
            return null;
        }
    }
}