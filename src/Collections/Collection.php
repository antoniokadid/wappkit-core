<?php

namespace AntonioKadid\WAPPKitCore\Collections;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

/**
 * Class Collection
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class Collection implements IteratorAggregate, Serializable, Countable, JsonSerializable
{
    /** @var array */
    protected $source;

    /**
     * Collection constructor.
     *
     * @param array|null $source
     */
    protected function __construct(array $source)
    {
        $this->source = &$source;
    }

    /**
     * Collection destructor.
     */
    public function __destruct()
    {
        unset($this->source);
    }

    /**
     * Convert to an ArrayList. Array keys are not preserved.
     *
     * @return ArrayList
     */
    public final function asList(): ArrayList
    {
        return new ArrayList($this->source);
    }

    /**
     * Convert to a Queue. Array keys are not preserved.
     *
     * @return Queue
     */
    public final function asQueue(): Queue
    {
        return new Queue($this->source);
    }

    /**
     * Convert to a Stack. Array keys are not preserved.
     *
     * @return Stack
     */
    public final function asStack(): Stack
    {
        return new Stack($this->source);
    }

    /**
     * Clears the contents of the collection.
     */
    public function clear(): void
    {
        unset($this->source);

        $this->source = [];
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->source);
    }

    /**
     * Get a copy version of the internal array.
     *
     * @return array
     */
    public final function getArrayCopy(): array
    {
        return $this->source;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->source);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->source;
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * @inheritdoc
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized, TRUE);
        if ($data === FALSE)
            throw new InvalidArgumentException('Unable to unserialize collection.');

        $this->source = $data;
    }

    /**
     * Get a reference to the internal array.
     *
     * @return array
     */
    public final function &toArray(): array
    {
        return $this->source;
    }
}
