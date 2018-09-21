<?php

namespace PHPCollections\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use ArrayIterator;

/**
 * The base for iterable, countable
 * and arrayable collections.
 */
abstract class BaseCollection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{

    /**
     * The data container.
     *
     * @var array
     */
    protected $data;

    /**
     * Represents the index of the data array.
     *
     * @var integer
     */
    private $position = 0;

    /**
     * BaseCollection constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Remove all the elements
     * of the data array.
     *
     * @return void
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Return the length of the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Check if the given index
     * exists in the collection.
     *
     * @param int $offset
     * 
     * @return bool
     */
    public function exists($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * Return an array iterator for
     * the data array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Defines the behavior of the collection
     * when json_encode is called.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Check if an offset exists in the collection.
     *
     * @param int $offset
     * 
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Get a value from the collection.
     *
     * @param int $offset
     
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * Set a value in the collection.
     *
     * @param int $offset
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            array_push($this->data, $value);
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Unset an offset in the collection.
     *
     * @param int $offset
     * 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Returns a plain array with
     * your dictionary data.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
