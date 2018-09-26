<?php

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\SortableInterface;
use PHPCollections\Interfaces\CollectionInterface;
use PHPCollections\Exceptions\InvalidOperationException;

/**
 * A list of values of any type
 */
class ArrayList extends BaseCollection implements CollectionInterface, IterableInterface, SortableInterface
{
    /**
     * Add a new element to the collection.
     *
     * @param mixed $value
     * 
     * @return void
     */
    public function add($value)
    {
        $data = $this->toArray();

        array_push($data, $value);
        $this->dataHolder->setContainer($data);
    }

    /**
     * Check if the collection
     * contains a given value.
     *
     * @param mixed $needle
     * 
     * @return bool
     */
    public function contains($needle)
    {
        return in_array($needle, $this->toArray());
    }

    /**
     * Return all the coincidences found
     * for the given callback or null.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function filter(callable $callback)
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
     * Search one or more elements in
     * the collection.
     *
     * @param callable $callback
     * @param boolean $shouldStop
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function find(callable $callback, $shouldStop = false)
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
     * Get the first element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function first()
    {
        if ($this->count() == 0) {
            throw new OutOfRangeException("You're trying to get data into an empty collection.");
        }

        return $this->dataHolder[0];
    }

    /**
     * Iterate over every element of the collection.
     *
     * @param callable $callback
     * 
     * @return void
     */
    public function forEach(callable $callback)
    {
        $data = $this->toArray();

        array_walk($data, $callback);
        $this->dataHolder->setContainer($data);
    }

    /**
     * Get the element specified
     * at the given index.
     *
     * @param int $offset
     * 
     * @return mixed
     */
    public function get($offset)
    {
        return $this->dataHolder->offsetGet($offset);
    }

    /**
     * Get the last element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function last()
    {
        if ($this->count() == 0) {
            throw new OutOfRangeException("You're trying to get data into an empty collection.");
        }

        return $this->dataHolder[$this->count() - 1];
    }

    /**
     * Update elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function map(callable $callback)
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this(array_values($matcheds)) : null;
    }

    /**
     * Merge new data with the actual
     * collection and returns a new one.
     *
     * @param array $data
     * 
     * @return \PHPCollections\ArrayList
     */
    public function merge(array $data)
    {
        return new $this(array_merge($this->toArray(), $data));
    }
    
    /**
     * Return a random element of
     * the collection
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return mixed
     */
    public function rand()
    {
        if ($this->count() == 0) {
            throw new InvalidOperationException('You cannot get a random element from an empty collection.');
        }

        $randomIndex = array_rand($this->dataHolder);
        
        return $this->get($randomIndex);
    }

    /**
     * Remove an item from the collection
     * and repopulate the data array.
     *
     * @param int $offset
     * @throws \OutOfRangeException
     * 
     * @return void
     */
    public function remove($offset)
    {
        if ($this->count() == 0) {
            throw new OutOfRangeException("You're trying to remove data into a empty collection.");
        }
        
        if (!$this->dataHolder->offsetExists($offset)) {
            throw new OutOfRangeException("The {$offset} index do not exits for this collection.");
        }

        $this->dataHolder->offsetUnset($offset);
    }

    /**
     * Return a new collection with the
     * reversed values.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return \PHPCollections\ArrayList
     */
    public function reverse()
    {
        if ($this->count() == 0) {
            throw new InvalidOperationException('You cannot reverse an empty collection.');
        }

        return new $this(array_reverse($this->toArray()));
    }

    /**
     * Sort collection data by values
     * applying a given callback.
     *
     * @param callable $callback
     * 
     * @return bool
     */
    public function sort(callable $callback)
    {
        $data = $this->toArray();
        $isSorted = usort($data, $callback);

        $this->dataHolder->setContainer($data);
        return $isSorted;
    }

    /**
     * Update the value of the element
     * at the given index.
     *
     * @param int $index
     * @param mixed $value
     * 
     * @return bool
     */
    public function update($index, $value)
    {
        if (!$this->exists($index)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->dataHolder->offsetSet($index, $value);
        
        return $this->dataHolder->offsetGet($index) === $value;
    }
}
