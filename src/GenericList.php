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
    public function __construct($type)
    {
        $this->type = $type;
        parent::__construct();
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
     * Return the first element that 
     * matches when callback criteria
     * 
     * @param callable $callback
     * @return object || null
     */
    public function find(callable $callback)
    {
        foreach ($this->data as $item) {
            if ($callback($item) === true) {
                $matched = $item;
                break;
            }
        }
        return $matched ?? null;
    }

    /**
     * Return the object at the specified index
     *
     * @param  int    $offset
     * @return object
     */
    public function get($offset)
    {
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
        if (count($this->data) == 0) {
            throw new OutOfRangeException("You're trying to remove data into a empty collection.");
        } else if (!offsetExists($offset)) {
            throw new OutOfRangeException("The {$offset} index do not exits for this collection, the valid index are from 0 to " . (count($this->data) - 1));
        }
        $this->offsetUnset($offset);
        $this->repopulate();
    }

}