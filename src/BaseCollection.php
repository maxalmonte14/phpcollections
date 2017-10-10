<?php

namespace PHPCollections;
use \ArrayAccess;
use \Countable;
use \Iterator;
use \JsonSerializable;

abstract class BaseCollection implements ArrayAccess, Countable, Iterator, JsonSerializable {

    /**
     * The data container
     *
     * @var array
     */
    protected $data;

    /**
     * Represents the index of the data array
     *
     * @var integer
     */
    private $position = 0;

    /**
     * BaseCollection constructor
     * 
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Return the length of the collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Return the current value of the collection
     *
     * @return mixed
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * Defines the behavior of the collection
     * when json_encode is called
     * 
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Return the actual key of the collection 
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Check if an offset exists in the collection
     *
     * @param  int  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Get a value in the collection
     *
     * @param  int  $offset
     * @return bool || null
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * Set a value in the collection
     *
     * @param  int   $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
            array_push($this->data, $value);
        else
            $this->data[$offset] = $value;
    }

    /**
     * Unset an offset in the collection
     *
     * @param  int  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Increase the position value in one
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return position to 0
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Check if exists an element 
     * in the actual position
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Repopulate the data array
     *
     * @return void
     */
    public function repopulate()
    {
        $values = array_values($this->data);
        $this->data = [];
        foreach ($values as $key => $value)
            $this->data[$key] = $value;
    }
}
