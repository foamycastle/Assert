<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   16:05
*/


namespace Foamycastle;

use Traversable;
use AllowDynamicProperties;

/**
 * @property-read string<value-of<KEY::*>>
 */
#[AllowDynamicProperties]
class MetaData implements MetaDataInterface
{
    private bool $readOnly = false;
    private array $data = [];

    /**
     * @param string<value-of<KEY::*>> $key
     * @param mixed $value
     * @return MetaDataInterface
     */
    function setValue(string $key, mixed $value): MetaDataInterface
    {
        if (!$this->hasKey($key)) {
            //TODO: Error: Key doesn't exist
        }
        if ($this->readOnly) {
            //TODO: Error: the metadata is readonly
        }
        return $this;
    }

    function isReadOnly(bool $readOnly): bool
    {
        return ($this->readOnly ?? false);
    }

    /**
     * @param string<value-of<KEY::*>> $key
     * @return MetaDataInterface
     */
    function clearKey(string $key): MetaDataInterface
    {
        if (!$this->hasKey($key)) {
            //TODO: Error: the key doesn't exist
        }
        if ($this->readOnly) {
            //TODO: Error: this metadata is readonly
        }
        unset($this->data[$key]);
        return $this;
    }

    /**
     * @param string<value-of<KEY::*>> $key
     * @return bool
     */
    function hasKey(string $key): bool
    {
        return isset($this->data[$key]);
    }


    /**
     * @param string<value-of<Key::*>> $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->hasKey($offset);
    }

    /**
     * @param string<value-of<Key::*>> $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return ($this->data[$offset] ?? null);
    }

    /**
     * @param string<value-of<Key::*>> $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->readOnly) return;
        $this->data[$offset] = $value;
    }

    /**
     * @param string<value-of<Key::*>> $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if ($this->readOnly) return;
        $this->clearKey($offset);
    }

    public function getIterator(): Traversable
    {
        foreach ($this->data as $key => $value) {
            yield $key => $value;
        }
    }

    public function count(): int
    {
        return empty($this->data)
            ? 0
            : count($this->data);
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * Ingest many data items in a single call
     * @param array $data
     * @return self
     */
    function ingest(array $data): MetaDataInterface
    {
        foreach ($data as $key => $value) {
            if (!is_string($key)) continue;
            $this->data[$key] = $value;
        }
        return $this;
    }

}