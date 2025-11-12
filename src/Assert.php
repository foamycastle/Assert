<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:43
*/


namespace Foamycastle;

use Error;
use Exception;
use ReflectionFunction;
use Foamycastle\Exception\ExpectationNotMet;

/**
 * @method static void HasClass(object $object, string $className)
 * @method static void IsTrue(mixed $testFixture)
 * @method static void IsFalse(mixed $testFixture)
 * @method static void IsANumber(mixed $data)
 */
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

    /**
     * Allow the test to take place and determine the result
     * @return void
     */
    protected function initTest(): void
    {
        try {
            $this->result = $this->assert() ? Result::Pass($this) : Result::Fail($this);
        } catch (Exception $exception) {
            if (Expect::Exception() && Expect::Get() == $exception::class) {
                $this->result = Result::ExpectedException($this);
            }
            if (!Expect::Exception()) {
                $this->result = Result::UnexpectedException($this);
            }
            $this->metadata['exception'] = $exception;
            return;
        } catch (Error $error) {
            if (Expect::Error() && Expect::Get() == $error::class) {
                $this->result = Result::ExpectedError($this);
            }
            if (!Expect::Error()) {
                $this->result = Result::UnexpectedError($this);
            }
            $this->metadata['error'] = $error;
            return;
        } finally {
            if (Expect::Exception()) {
                throw new ExpectationNotMet($this);
            }
            Expect::Nothing();
        }
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