<?php

namespace AntonioKadid\WAPPKitCore\Collections;

/**
 * Class Stack
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class Stack extends Collection
{
    /**
     * Stack constructor.
     *
     * @param array $source An array to initialize stack. Array keys are not preserved. [optional]
     */
    public function __construct(array $source = [])
    {
        parent::__construct(array_values($source));
    }

    /**
     * Returns the object at the top of the stack without removing it.
     *
     * @return mixed
     */
    public function peek()
    {
        return array_shift(array_slice($this->source, -1, 1));
    }

    /**
     * Removes and returns the object at the top of the stack.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->source);
    }

    /**
     * Inserts an object at the top of the stack.
     *
     * @param $value
     */
    public function push($value)
    {
        array_push($this->source, $value);
    }
}