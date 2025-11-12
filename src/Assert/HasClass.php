<?php
/*
 *  Author: Aaron Sollman
 *  Email:  unclepong@gmail.com
 *  Date:   11/11/25
 *  Time:   20:48
*/


namespace Foamycastle\Assert;

use Foamycastle\Assert;

class HasClass extends Assert
{
    private string $className;
    private object $object;

    public function __construct(object $object, string $className)
    {
        $this->className = $className;
        $this->object = $object;
        parent::__construct($object, $className);
    }

    /**
     * @return array
     */
    protected function metadata(): array
    {
        return [
            'name' => basename($this::class),
            'description' => 'the object has the class in its inheritance tree',
        ];
    }


    public function assert(): bool
    {
        $parents = class_parents($this->object);
        return in_array($this->className, array_merge($parents, [$this->object::class]));
    }
}