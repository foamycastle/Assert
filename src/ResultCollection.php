<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/12/25
 *  Time:   10:33
*/


namespace Foamycastle;

use Countable;
use Iterator;
use IteratorAggregate;


class ResultCollection implements ResultCollectionInterface, Countable, IteratorAggregate
{
    /**
     * @var ResultInterface[]
     */
    protected array $results = [];

    public function __construct()
    {
        $this->results = Result::Collection();
        Result::Clear();
    }

    function findByName(string $name): ResultCollectionInterface
    {
        $collection = [];
        while ($this->getIterator()->valid()) {
            if ($this->getIterator()->current()->getName() == $name) {
                $collection[] = $this->getIterator()->current();
            }
        }
        return new ResultCollection($collection);
    }

    function findByResultType(string $resultClass): ResultCollectionInterface
    {
        $collection = [];
        while ($this->getIterator()->valid()) {
            if ($this->getIterator()->current()::class == $resultClass) {
                $collection[] = $this->getIterator()->current();
            }
        }
        return new ResultCollection($collection);
    }

    function findByMetaData(string $key, string $value): ResultCollectionInterface
    {
        $collection = [];
        while ($this->getIterator()->valid()) {
            /**
             * @var MetaDataInterface $metadata
             */
            $metadata = $this->getIterator()->current()->getAssertion();
            if ($metadata->hasKey($key) && $metadata[$key] == $value) {
                $collection[] = $this->getIterator()->current();
            }
        }
        return new ResultCollection($collection);
    }

    /**
     * @return ResultInterface[]
     */
    function getSearchResults(): array
    {
        return ($this->results ?? []);
    }

    /**
     * @return Iterator
     */
    public function getIterator(): Iterator
    {
        reset($this->results);
        foreach ($this->results as $result) {
            /**
             * @var ResultInterface $result
             */
            yield $result;
        }
        return null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->results);
    }
}