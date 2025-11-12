<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   15:46
*/


namespace Foamycastle;

use Foamycastle\MetaData\Key;
use Foamycastle\Result\ExpectedError;
use Foamycastle\Result\ExpectedException;
use Foamycastle\Result\NegativeResult;
use Foamycastle\Result\PositiveResult;
use Foamycastle\Result\UnexpectedError;
use Foamycastle\Result\UnexpectedException;

abstract class Result implements ResultInterface
{
    protected Assert $assertion;
    private static array $results = [];

    protected function __construct(Assert $assertion)
    {
        $this->assertion = $assertion;
    }

    abstract public function result(): bool;

    public function getAssertion(): Assert
    {
        return $this->assertion;
    }

    public static function Pass(Assert $assertion): self
    {
        return new PositiveResult($assertion);
    }

    public static function Fail(Assert $assertion): self
    {
        return new NegativeResult($assertion);
    }

    public static function ExpectedException(Assert $assertion): self
    {
        return new ExpectedException($assertion);
    }

    public static function UnexpectedException(Assert $assertion): self
    {
        return new UnexpectedException($assertion);
    }

    public static function ExpectedError(Assert $assertion): self
    {
        return new ExpectedError($assertion);
    }

    public static function UnexpectedError(Assert $assertion): self
    {
        return new UnexpectedError($assertion);
    }

    public static function Collect(Result $result): null|int
    {
        $currentCount = count(self::$results) + 1;
        $metadata = $result->assertion->metadata;
        if (!$metadata->hasKey(Key::NAME)) {
            $metadata[Key::NAME] = "Unnamed Test " . $currentCount;
        }
        if (!$metadata->hasKey(Key::DESC)) {
            $metadata[Key::DESC] = "Undescribed Test " . $currentCount;
        }
        $metadata[Key::IDX] = $currentCount;
        self::$results[] = $result;
        return count(self::$results);
    }

    public static function Clear(): int
    {
        self::$results = [];
        return 0;
    }

    /**
     * @param string $name
     * @return Result[]
     */
    public static function FindByName(string $name): array
    {
        $output = [];
        foreach (self::$results as $result) {
            if ($result->assertion()->getName() === $name) {
                $output[] = $result;
            }
        }
        return $output;
    }

    /**
     * @return Result[]
     */
    public static function Collection(): array
    {
        return self::$results;
    }

    public static function Previous(): ?Result
    {
        return end(self::$results) ?: null;
    }
}