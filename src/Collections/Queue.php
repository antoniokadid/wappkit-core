<?php

namespace AntonioKadid\WAPPKitCore\Collections;

/**
 * Class Queue
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class Queue extends Collection
{
    /**
     * Queue constructor.
     *
     * @param array $source An array to initialize queue. Array keys are not preserved. [optional]
     */
    public function __construct(array $source = [])
    {
        parent::__construct(array_values($source));
    }

    /**
     * Removes and returns the object at the beginning of the queue.
     *
     * @return mixed
     */
    public function dequeue()
    {
        return array_shift($this->source);
    }

    /**
     * Adds an object to the end of the queue.
     *
     * @param mixed $object
     */
    public function enqueue($object)
    {
        array_push($this->source, $object);
    }

    /**
     * Returns the object at the beginning of the queue without removing it.
     *
     * @return mixed
     */
    public function peek()
    {
        return array_shift(array_slice($this->source, 0, 1));
    }
}