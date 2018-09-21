<?php

namespace PHPCollections\Collections;

use PHPCollections\Exceptions\InvalidOperationException;

/**
 * A list of values of any type
 */
class ArrayList extends BaseCollection
{
    /**
     * Add a new element to the collection.
     *
     * @param  mixed $val
     * 
     * @return void
     */
    public function add($val)
    {
        $this->data[] = $val;
    }

    /**
     * Check if the collection
     * contains a given value.
     *
     * @param  mixed $val
     * 
     * @return bool
     */
    public function contains($val)
    {
        foreach ($this->data as $value) {
            if ($value === $val) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return all the coincidences found
     * for the given callback or null.
     *
     * @param  callable $callback
     * @return \PHPCollections\ArrayList|null
     */
    public function filter(callable $callback)
    {
        $matcheds = [];

        foreach ($this->data as $value) {
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
     * @param  callable $callback
     * @param  boolean  $shouldStop
     * 
     * @return \PHPCollections\ArrayList|null
     */
    public function find(callable $callback, $shouldStop = false)
    {
        $matcheds = [];

        foreach ($this->data as $key => $item) {
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

        return $this->data[0];
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
        return $this->offsetGet($offset);
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

        return $this->data[$this->count() - 1];
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
        $matcheds = array_map($callback, $this->data);

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
        return new $this(array_merge($this->data, $data));
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

        $randomIndex = array_rand($this->data);
        
        return $this->get($randomIndex);
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
        return new $this(array_reverse($this->data));
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

        $this->data[$index] = $value;
        
        return $this->data[$index] === $value;
    }
}
