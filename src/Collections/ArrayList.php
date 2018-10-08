<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Exceptions\InvalidOperationException;
use PHPCollections\Interfaces\CollectionInterface;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\MergeableInterface;
use PHPCollections\Interfaces\SortableInterface;

/**
 * A list of values of any type.
 */
class ArrayList extends BaseCollection implements CollectionInterface, IterableInterface, MergeableInterface, SortableInterface
{
    /**
     * Adds a new element to the collection.
     *
     * @param mixed $value
     *
     * @return void
     */
    public function add($value): void
    {
        $data = $this->toArray();

        array_push($data, $value);
        $this->dataHolder->setContainer($data);
    }

    /**
     * Checks if the collection
     * contains a given value.
     *
     * @param mixed $needle
     *
     * @return bool
     */
    public function contains($needle): bool
    {
        return in_array($needle, $this->toArray());
    }

    /**
     * Returns all the coincidences found
     * for the given callback or null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\ArrayList|null
     */
    public function filter(callable $callback): ?self
    {
        $matcheds = [];

        foreach ($this->dataHolder as $value) {
            if (call_user_func($callback, $value) === true) {
                $matcheds[] = $value;
            }
        }

        return count($matcheds) > 0 ? new $this(array_values($matcheds)) : null;
    }

    /**
     * Searches for one or more elements
     * in the collection.
     *
     * @param callable $callback
     * @param bool     $shouldStop
     *
     * @return \PHPCollections\ArrayList|null
     */
    public function find(callable $callback, bool $shouldStop = false): ?self
    {
        $matcheds = [];

        foreach ($this->dataHolder as $key => $item) {
            if ($callback($item, $key) === true) {
                $matcheds[] = $item;

                if ($shouldStop) {
                    break;
                }
            }
        }

        return count($matcheds) > 0 ? new $this($matcheds) : null;
    }

    /**
     * Iterates over every element of the collection.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function forEach(callable $callback): void
    {
        $data = $this->toArray();

        array_walk($data, $callback);
        $this->dataHolder->setContainer($data);
    }

    /**
     * Gets the element specified
     * at the given index.
     *
     * @param int $offset
     *
     * @return mixed
     */
    public function get(int $offset)
    {
        return $this->dataHolder->offsetGet($offset);
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\ArrayList|null
     */
    public function map(callable $callback): ?self
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this(array_values($matcheds)) : null;
    }

    /**
     * Merges two ArrayList into a new one.
     *
     * @param \PHPCollections\Collections\ArrayList $newArrayList
     *
     * @return \PHPCollections\Collections\ArrayList
     */
    public function merge(BaseCollection $newArrayList): BaseCollection
    {
        return new $this(array_merge($this->toArray(), $newArrayList->toArray()));
    }

    /**
     * Returns a random element of
     * the collection.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return mixed
     */
    public function rand()
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot get a random element from an empty collection');
        }

        $randomIndex = array_rand($this->dataHolder);

        return $this->get($randomIndex);
    }

    /**
     * Removes an item from the collection
     * and repopulates the data array.
     *
     * @param int $offset
     *
     * @throws \OutOfRangeException
     *
     * @return void
     */
    public function remove(int $offset): void
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to remove data from an empty collection');
        }

        if (!$this->dataHolder->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index does not exists for this collection', $offset));
        }

        $this->dataHolder->offsetUnset($offset);
    }

    /**
     * Returns a new collection with the
     * reversed values.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\ArrayList
     */
    public function reverse(): self
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot reverse an empty collection');
        }

        return new $this(array_reverse($this->toArray()));
    }

    /**
     * Returns a new ArrayList with the
     * values ordered by a given callback
     * if couldn't sort returns null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\ArrayList|null
     */
    public function sort(callable $callback): ?BaseCollection
    {
        $data = $this->toArray();

        return usort($data, $callback) ? new $this($data) : null;
    }

    /**
     * Updates the value of the element
     * at the given index.
     *
     * @param int   $index
     * @param mixed $value
     *
     * @return bool
     */
    public function update(int $index, $value): bool
    {
        if (!$this->exists($index)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->dataHolder->offsetSet($index, $value);

        return $this->dataHolder->offsetGet($index) === $value;
    }
}
