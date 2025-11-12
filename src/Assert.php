<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:43
*/


namespace Foamycastle;

use ReflectionFunction;

abstract class Assert implements AssertionSetInterface, AssertionGetInterface
{
    /**
     * A name by which to identify the assertion in reporting
     * @var string|class-string
     */
    protected string $name;

    /**
     * The result of the assertion procedure logic
     * @var Result
     */
    protected Result $result;

    /**
     * @var callable $procedure
     */
    protected $procedure;

    /**
     * The values of the arguments passed to the procedure
     * @var array
     */
    protected array $procedureParams;

    /**
     * The names of the arguments passed to the procedure
     * @var array
     */
    protected array $procedureParamNames;

    /**
     * data that is not germaine to the procedure, but may have generated during the procedure that is relevant elsewhere
     * @var array
     */
    protected MetaDataInterface $metaData;

    abstract public function assert(): bool;

    /**
     * @inheritDoc
     */
    function metadata(string $key = "", $value = ""): mixed
    {
        if ($key == "" && empty($value)) return $this->metaData;
        if (empty($value)) return $this->metaData;
        return $this->metaData->setValue($key, $value);
    }

    /**
     * @inheritDoc
     */
    function setName(string $name): AssertionSetInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    function getName(): string
    {
        return $this->name;
    }

    protected function getReflection($procedure): void
    {
        $this->procedure = new ReflectionFunction($procedure);
        $this->procedureParamNames = $this->procedure->getParameters();
    }

    /**
     * @return MetadataInterface
     */
    function getMetadata(): MetadataInterface
    {
        return $this->metaData;
    }

    /**
     * @return array
     */
    function getParamNames(): array
    {
        return $this->procedureParamNames;
    }

    /**
     * @return array
     */
    function getParamValues(): array
    {

    }

}