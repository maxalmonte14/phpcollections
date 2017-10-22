<?php

namespace PHPCollections\Collections;

use OutOfRangeException;
use InvalidArgumentException;
use PHPCollections\Exceptions\InvalidOperationException;

class GenericList extends BaseCollection {

    /**
     * The type of data that's
     * gonna be stored
     * 
     * @var mixed
     */
    private $type;

    /**
     * The GenericList class constructor
     *
     * @param  string $type
     * @param  array  $data
     * @return void
     */
    public function __construct($type, array $data = [])
    {
        $this->type = $type;
        foreach ($data as $value) $this->checkType($value);
        parent::__construct($data);
    }

    /**
     * Add a new object to the collection
     *
     * @param  object $value
     * @return void
     */
    public function add($value)
    {
        $this->checkType($value);
        array_push($this->data, $value);
    }

    /**
     * Determine if the passed data is
     * of the type specified in the type
     * attribute, if not raise and Exception
     *
     * @param  mixed $data
     * @throws InvalidArgumentException     
     * @return void
     */
    private function checkType($data)
    {
        if (!$data instanceof $this->type) {
            $type = is_object($data) ? get_class($data) : gettype($data);
            throw new InvalidArgumentException(
                sprintf('The type specified for this collection is %s, you cannot pass a value of type %s', $this->type, $type)
            );
        }
    }

    /**
     * Return all the coincidences found
     * for the given callback or null
     * 
     * @param  callable $callback
     * @return PHPCollections\GenericList|null
     */
    public function filter(callable $callback)
    {
        $matcheds = [];
        foreach ($this->data as $key => $value) {
            if (call_user_func($callback, $key, $value) === true)
                $matcheds[] = $value;
        }
        return count($matcheds) > 0 ? new $this($this->type, array_values($matcheds)) : null;
    }

    /**
     * Return the first element that
     * matches when callback criteria
     * 
     * @param  callable    $callback
     * @return PHPCollections\GenericList|null
     */
    public function find(callable $callback)
    {
        $dataset = $this->search($callback, true);
        return $dataset->get(0) ?? null;
    }

    /**
     * Get the first element of the collection
     *
     * @throws OutOfRangeException
     * @return mixed
     */
    public function first()
    {
        if ($this->count() == 0)
            throw new OutOfRangeException("You're trying to get data into an empty collection.");
        return $this->data[0];
    }

    /**
     * Return the object at the specified index
     *
     * @param  int    $offset
     * @throws OutOfRangeException
     * @return object
     */
    public function get($offset)
    {
        if ($this->count() == 0)
            throw new OutOfRangeException("You're trying to get data into an empty collection.");
        else if (!$this->offsetExists($offset))
            throw new OutOfRangeException("The {$offset} index do not exits for this collection.");
        return $this->offsetGet($offset);
    }

    /**
     * Get the last element of the collection
     *
     * @throws OutOfRangeException
     * @return mixed
     */
    public function last()
    {
        if ($this->count() == 0)
            throw new OutOfRangeException("You're trying to get data into an empty collection.");
        return $this->data[$this->count() - 1];
    }

    /**
     * Update elements in the collection by
     * applying a given callback function
     *
     * @param  callable $callback
     * @return PHPCollections\GenericList|null
     */
    public function map(callable $callback)
    {
        $matcheds = array_map($callback, $this->data);
        return count($matcheds) > 0 ? new $this($this->type, array_values($matcheds)) : null;
    }

    /**
     * Merge new data with the actual
     * collection and returns a new one
     *
     * @param  array $data
     * @return PHPCollections\GenericList
     */
    public function merge(array $data)
    {
        foreach ($data as $value) $this->checkType($value);
        return new $this($this->type, array_merge($this->data, $data));
    }

    /**
     * Return a random element of 
     * the collection
     *
     * @throws PHPCollections\Exceptions\InvalidOperationException
     * @return mixed
     */
    public function rand()
    {
        if ($this->count() == 0)
            throw new InvalidOperationException('You cannot get a random element from an empty collection.');
        $randomIndex = array_rand($this->data);
        return $this->get($randomIndex);
    }

    /**
     * Remove an item in the collection
     * and repopulate the data array
     * 
     * @param  int  $offset
     * @throws OutOfRangeException
     * @return void
     */
    public function remove($offset)
    {
        if ($this->count() == 0)
            throw new OutOfRangeException("You're trying to remove data into a empty collection.");
        else if (!$this->offsetExists($offset))
            throw new OutOfRangeException("The {$offset} index do not exits for this collection.");
        $this->offsetUnset($offset);
        $this->repopulate();
    }

    /**
     * Repopulate the data array
     *
     * @return void
     */
    public function repopulate()
    {
        $this->data = array_values($this->data);
    }

    /**
     * Return a new collection with the
     * reversed values
     * 
     * @throws PHPCollections\Exceptions\InvalidOperationException
     * @return PHPCollections\GenericList
     */
    public function reverse()
    {
        if ($this->count() == 0)
            throw new InvalidOperationException('You cannot reverse an empty collection.');
        return new $this($this->type, array_reverse($this->data));
    }

    /**
     * Search one or more elements in
     * the collection
     * 
     * @param  callable $callback
     * @param  boolean  $shouldStop
     * @return PHPCollections\GenericList|null
     */
    public function search(callable $callback, $shouldStop = false)
    {
        $matcheds = [];
        foreach ($this->data as $key => $item) {
            if ($callback($item, $key) === true) {
                $matcheds[] = $item;
                if ($shouldStop) break;
            }
        }
        return count($matcheds) > 0 ? new $this($this->type, $matcheds) : null;
    }

    /**
     * Sort collection data by values
     * applying a given callback
     *
     * @param  callable $callback
     * @return bool
     */
    public function sort(callable $callback)
    {
        return usort($this->data, $callback);
    }
}