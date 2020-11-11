<?php

namespace AntonioKadid\WAPPKitCore\Collections;

use InvalidArgumentException;

use function max;
use function min;

/**
 * Class ArrayList.
 *
 * @package AntonioKadid\WAPPKitCore\Collections
 */
class ArrayList extends Collection
{
    /**
     * ArrayList constructor.
     *
     * @param array $source An array to initialize list. Array keys are not preserved. [optional]
     */
    public function __construct(array $source = [])
    {
        parent::__construct(array_values($source));
    }

    /**
     * Adds an object to the end of the list.
     *
     * @param mixed $object
     *
     * @return ArrayList
     */
    public function add($object): ArrayList
    {
        array_push($this->source, $object);

        return $this;
    }

    /**
     * Adds the elements of a collection to the end of the list.
     *
     * @param Collection $array $array
     *
     * @return ArrayList
     */
    public function addRange(Collection $array): ArrayList
    {
        $this->source = array_merge($this->source, array_values($array->source));

        return $this;
    }

    /**
     * Applies an accumulator function over a list.
     *
     * @param callable $accumulator
     *
     * @return mixed
     */
    public function aggregate(callable $accumulator)
    {
        if (!$this->any()) {
            return null;
        }

        $initial = $this->take();
        $source  = $this->skip();

        return array_reduce($source->source, $accumulator, $initial->source[0]);
    }

    /**
     * Determines whether all the elements of a list satisfy a condition.
     *
     * @param callable $predicate
     *
     * @return bool
     */
    public function all(callable $predicate): bool
    {
        foreach ($this->source as $element) {
            if (@call_user_func_array($predicate, [$element]) !== true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determines whether a list contains any elements.
     * If a condition is specified then determines whether there are any elements that satisfy the condition.
     *
     * @param null|callable $predicate
     *
     * @return bool
     */
    public function any(?callable $predicate = null): bool
    {
        if ($predicate == null) {
            return count($this->source) !== 0;
        }

        return $this->findAll($predicate)->any();
    }

    /**
     * Searches for an element that matches the conditions defined by the specified predicate,
     * and returns the first occurrence.
     *
     * @param callable $predicate
     *
     * @return ArrayList
     */
    public function find(callable $predicate): ArrayList
    {
        return $this
            ->findAll($predicate)
            ->take();
    }

    /**
     * Retrieves all the elements that match the conditions defined by the specified predicate.
     *
     * @param callable $predicate
     *
     * @return ArrayList
     */
    public function findAll(callable $predicate): ArrayList
    {
        return new ArrayList(array_filter($this->source, $predicate));
    }

    /**
     * Returns the first actual element from the list. If the list is empty NULL is returned.
     *
     * @return null|mixed
     */
    public function flat()
    {
        if ($this->any()) {
            return $this->take(1)->source[0];
        }

        return null;
    }

    /**
     * Groups the elements of a list.
     * Grouping works <i>with a copy</i> of the internal array.
     *
     * @param callable[] ...$groupKeySelectors
     *
     * @return ArrayList
     */
    public function groupBy(...$groupKeySelectors): ArrayList
    {
        $keySelector = array_shift($groupKeySelectors);
        if (!is_callable($keySelector)) {
            return $this;
        }

        $result = new ArrayList();

        foreach ($this->source as $value) {
            $key = call_user_func_array($keySelector, [$value]);

            $group = $result->find(function (ArrayListGroup $group) use ($key) {
                return $group->key === $key;
            })->flat();

            if ($group == null) {
                $group = new ArrayListGroup($key, new ArrayList());
                $result->add($group);
            }

            $group->group->add($value);
        }

        if (count($groupKeySelectors) == 0) {
            return $result;
        }

        array_walk(
            $result->source,
            function (&$value, $index, $selectors) {
                if ($value instanceof ArrayListGroup) {
                    $value->group = call_user_func_array([$value->group, 'groupBy'], $selectors);
                }
            },
            $groupKeySelectors
        );

        return $result;
    }

    /**
     * Searches for the specified object and returns the index of its first occurrence in a list.
     *
     * @param mixed $object
     *
     * @return null|int|string
     */
    public function indexOf($object)
    {
        foreach ($this->source as $offset => $item) {
            if ($item === $object) {
                return $offset;
            }
        }

        return null;
    }

    /**
     * Returns a specified number of contiguous elements from the end of a list.
     *
     * @param int $count
     *
     * @return ArrayList
     */
    public function last(int $count = 1): ArrayList
    {
        if ($count <= 0) {
            throw new InvalidArgumentException(sprintf('%s cannot be less than or equal to 0.', '$count'));
        }

        return new ArrayList(array_slice($this->source, -$count, $count));
    }

    /**
     * Returns the maximum value in a list.
     * If a selector is specified then first projects each element of a list into a new form.
     *
     * @param null|callable $selector
     *
     * @return mixed
     */
    public function max(?callable $selector = null)
    {
        if ($selector == null) {
            return max($this->source);
        }

        return $this
            ->select($selector)
            ->max();
    }

    /**
     * Returns the minimum value in a list.
     * If a selector is specified then first projects each element of a list into a new form.
     *
     * @param null|callable $selector
     *
     * @return mixed
     */
    public function min(?callable $selector = null)
    {
        if ($selector == null) {
            return min($this->source);
        }

        return $this
            ->select($selector)
            ->min();
    }

    /**
     * Returns a specified number of random elements.
     *
     * @param int $count
     *
     * @return ArrayList
     */
    public function random(int $count = 1): ArrayList
    {
        if ($count <= 0) {
            throw new InvalidArgumentException(sprintf('%s cannot be less than or equal to 0.', '$count'));
        }

        $values = $this->getArrayCopy();

        return (new ArrayList((shuffle($values) === false) ? $this->source : $values))
            ->take($count);
    }

    /**
     * Removes the first occurrence of a specific object from the list.
     *
     * @param mixed $object
     *
     * @return ArrayList
     */
    public function remove($object): ArrayList
    {
        foreach ($this->source as $index => $item) {
            if ($item === $object) {
                return $this->removeAt($index);
            }
        }

        return $this;
    }

    /**
     * Removes the list item at the specified index.
     *
     * @param mixed $index
     *
     * @return ArrayList
     */
    public function removeAt($index): ArrayList
    {
        if (array_key_exists($index, $this->source)) {
            array_splice($this->source, $index, 1);
        }

        return $this;
    }

    /**
     * Projects each element of a list into a new form.
     *
     * @param callable $selector
     *
     * @return ArrayList
     */
    public function select(callable $selector): ArrayList
    {
        return new ArrayList(array_map($selector, $this->source));
    }

    /**
     * Bypasses a specified number of elements in a list and then returns the remaining elements.
     *
     * @param int $count
     *
     * @return ArrayList
     */
    public function skip(int $count = 1): ArrayList
    {
        return new ArrayList(array_slice($this->source, $count));
    }

    /**
     * Initiate sorting of list.
     * Sorting works <i>by the reference to</i> the internal array.
     *
     * @return ArrayListSorter
     */
    public function sort(): ArrayListSorter
    {
        return new ArrayListSorter($this);
    }

    /**
     * Computes the sum of a list of numeric values.
     * If a selector is specified then first projects each element of a list into a new form.
     *
     * @param null|callable $selector
     *
     * @return float|int
     */
    public function sum(?callable $selector = null)
    {
        if ($selector == null) {
            return array_sum(
                $this->findAll(function ($element) {
                    return is_int($element) || is_float($element);
                })->source
            );
        }

        return $this
            ->select($selector)
            ->sum();
    }

    /**
     * Returns a specified number of contiguous elements from the start of a list.
     *
     * @param int $count
     *
     * @return ArrayList
     */
    public function take(int $count = 1): ArrayList
    {
        if ($count <= 0) {
            throw new InvalidArgumentException(sprintf('%s cannot be less than or equal to 0.', '$count'));
        }

        return new ArrayList(array_slice($this->source, 0, $count));
    }
}
