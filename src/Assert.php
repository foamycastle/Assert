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
     * @inheritDoc
     */
    abstract protected function metadata(): array;

    protected function __construct(...$args)
    {
        $result = $this->assert();
        $this->result = $result ? Result::Pass($this) : Result::Fail($this);
    }


    protected function getReflection(): void
    {
        $this->procedure = new ReflectionFunction($procedure);
        $this->procedureParamNames = $this->procedure->getParameters();
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