<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\SortableInterface;
use PHPCollections\Interfaces\CollectionInterface;
use PHPCollections\Exceptions\InvalidOperationException;

/**
 * A list of values of any type.
 */
class ArrayList extends BaseCollection implements CollectionInterface, IterableInterface, SortableInterface
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
    public function filter(callable $callback): ?ArrayList
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
     * @param bool $shouldStop
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function find(callable $callback, bool $shouldStop = false): ?ArrayList
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
     * Gets the first element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function first()
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection.');
        }

        return $this->dataHolder[0];
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
     * Gets the last element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function last()
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection.');
        }

        return $this->dataHolder[$this->count() - 1];
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function map(callable $callback): ?ArrayList
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this(array_values($matcheds)) : null;
    }

    /**
     * Merges new data with the actual
     * collection and returns a new one.
     *
     * @param array $data
     * 
     * @return \PHPCollections\ArrayList
     */
    public function merge(array $data): ArrayList
    {
        return new $this(array_merge($this->toArray(), $data));
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
        if ($this->count() === 0) {
            throw new InvalidOperationException('You cannot get a random element from an empty collection.');
        }

        $randomIndex = array_rand($this->dataHolder);
        
        return $this->get($randomIndex);
    }

    /**
     * Removes an item from the collection
     * and repopulates the data array.
     *
     * @param int $offset
     * @throws \OutOfRangeException
     * 
     * @return void
     */
    public function remove(int $offset): void
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to remove data from an empty collection.');
        }
        
        if (!$this->dataHolder->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index does not exits for this collection.', $offset));
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
    public function reverse(): ArrayList
    {
        if ($this->count() === 0) {
            throw new InvalidOperationException('You cannot reverse an empty collection.');
        }

        return new $this(array_reverse($this->toArray()));
    }

    /**
     * Sorts collection's data by values
     * applying a given callback.
     *
     * @param callable $callback
     * 
     * @return bool
     */
    public function sort(callable $callback): bool
    {
        $data = $this->toArray();
        $isSorted = usort($data, $callback);

        $this->dataHolder->setContainer($data);
        return $isSorted;
    }

    /**
     * Updates the value of the element
     * at the given index.
     *
     * @param int $index
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
