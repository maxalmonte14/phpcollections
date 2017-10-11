<?php

namespace PHPCollections;

use \InvalidArgumentException;
use \OutOfRangeException;

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
     * @return void
     */
    public function __construct($type, $data = [])
    {
        $this->type = $type;
        parent::__construct($data);
    }

    /**
     * Add a new object to the collection
     *
     * @param  object $value
     * @throws InvalidArgumentException
     * @return void
     */
    public function add($value)
    {
        if (!($value instanceof $this->type))
            throw new InvalidArgumentException("You cannot add different values to {$this->type} into this GenericList");
        array_push($this->data, $value);
    }

    /**
     * Remove all the storaged data
     *
     * @return void
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Return all the coincidences found
     * for the given callback or null
     * 
     * @param  callable $callback
     * @return PHPCollections\GenericList|null
     */
    public function filter(callable $callback, $useBoth = true)
    {
        $flag = $useBoth ? ARRAY_FILTER_USE_BOTH : ARRAY_FILTER_USE_KEY;
        try {
            $matcheds = array_filter($this->data, $callback, $flag);
            return count($matcheds) > 0 ? new $this($this->type, array_values($matcheds)) : null;
        } catch (ArgumentCountError $e) {
            throw new ArgumentCountError('You must pass only 1 parameter to your Closure when the second argument was false.');
        }
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
     * Return the object at the specified index
     *
     * @param  int    $offset
     * @throws OutOfRangeException
     * @return object
     */
    public function get($offset)
    {
        if ($this->count() == 0)
            throw new OutOfRangeException("You're trying to get data into a empty collection.");
        else if (!$this->offsetExists($offset))
            throw new OutOfRangeException("The {$offset} index do not exits for this collection.");
        return $this->offsetGet($offset);
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

}