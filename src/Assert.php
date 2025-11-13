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
use Foamycastle\Exception\AssertionDoesntExist;
use Foamycastle\Exception\ExpectationNotMet;
use Foamycastle\MetaData\Key;
use ReflectionException;
use ReflectionFunction;

/**
 * @method static void IsABool(mixed $bool)
 * @method static void IsAnArray(mixed $array)
 * @method static void IsAString(mixed $string)
 */
abstract class Assert implements FixtureAccess
{
    /**
     * @var array contains the data that will be subject to test in the assert() method
     */
    protected array $fixture;
    /**
     * The result object. Mainly responsible for collecting and managing the assert results in a static space, an innstance will
     * hold a reference to an assertion object, as well as provide a method for exposing a true/false assertion result.
     * @var Result $result
     */
    protected Result $result;

    /**
     * Data surrounding the procedure, such as reflection objects detailing the arguments to the procedure
     * @var MetaDataInterface $metadata
     */
    public MetaDataInterface $metadata;

    /**
     * The actual procedure.  The business logic of determining the assertion result.
     * @return bool
     */
    abstract protected function assert(): bool;

    /**
     * Other parameters that are optional to the test
     * @var array<string,mixed> $otherParams
     */
    protected array $otherParams;

    /**
     * @return array returns default metadata to the `Metadata` object. typically the 'name' and 'description' elements are set in this manner.
     */
    abstract protected function metadata(): array;

    /**
     * The Assert class serves as a base for extending different types of assertions.  The immediate classes in the inheritance
     * tree are `SingleFixture` and `MultiFixture`.
     * @param ...$args
     * @throws ExpectationNotMet
     */
    protected function __construct(...$args)
    {
        $this->metadata = new MetaData();
        $this->metadata->ingest($this->metadata());
        $this->metadata[Key::P_VAL] = $args;
        $this->fixture = $args;
        $this->getReflection();
        $this->initTest();

        Result::Collect($this->result);
    }

    /**
     * Serves as a getting for test fixture data as well as data from `otherParams` field.  The test fixture get takes precedence over the
     * `otherParams` get.
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (key_exists($name, $this->fixture)) {
            return $this->fixture[$name];
        }
        if (key_exists($name, $this->otherParams)) {
            return $this->otherParams[$name];
        }
        return null;
    }

    /**
     * Serves as a setting for `otherParams` only. Test fixture setting is not performed in this method
     * @param string $name
     * @param $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        if (key_exists($name, $this->fixture)) return;
        $this->otherParams[$name] = $value;
    }

    /**
     * First, try to run the test assertion and determine the result. If an exception is thrown during the test,
     * collect the `ExceptionResult` or `ErrorResult` objects instead of a pass or fail result. Finally, clear the exception
     * expectation state.
     * @return void
     * @throws ExpectationNotMet
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
            $this->metadata[Key::EX] = $exception;
            return;
        } catch (Error $error) {
            if (Expect::Error() && Expect::Get() == $error::class) {
                $this->result = Result::ExpectedError($this);
            }
            if (!Expect::Error()) {
                $this->result = Result::UnexpectedError($this);
            }
            $this->metadata[Key::ERR] = $error;
            return;
        } finally {
            if (Expect::Exception()) {
                throw new ExpectationNotMet($this);
            }
            Expect::Nothing();
        }
    }

    /**
     * Reflect the constructor method of the object to determine the input fixture names, information gathered for reporting.
     * @return void
     * @throws ReflectionException
     */
    protected function getReflection(): void
    {
        $reflection = new ReflectionFunction($this->__construct(...));
        $this->metadata[KEY::PROC] = $reflection;
        $this->metadata[Key::P_NAME] = $reflection->getParameters();
    }

    /**
     * Calls to `Assert` child classes may be accomplished via blind static calls to the `Assert` __callStatic method
     * @param string $name
     * @param array $arguments
     * @return void
     * @throws AssertionDoesntExist
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $sf = __NAMESPACE__ . "\\Assert\\SingleFixture\\" . $name;
        $mf = __NAMESPACE__ . "\\Assert\\MultiFixture\\" . $name;
        if (class_exists($mf)) {
            new $mf(...$arguments);
            return;
        }
        if (class_exists($sf)) {
            new $sf($arguments[0]);
            return;
        }
        throw new AssertionDoesntExist($name);
    }

    /**
     * Return the names of the arguments passed to the constructor
     * @return array
     */
    function getFixtureNames(): array
    {
        return array_keys($this->fixture);
    }

    /**
     * Indicates that a fixture by a given name is present
     * @param string $name
     * @return bool
     */
    function hasFixture(string $name): bool
    {
        return ($this->fixture[$name] ?? false);
    }

    /**
     * @param string $index
     * @return mixed
     */
    function getFixture(string $index): mixed
    {
        return $this->fixture[$index] ?? null;
    }

}