<?php

namespace PHPCollections;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class DataHolder implements ArrayAccess, IteratorAggregate
{
    /**
     * The array for storing data.
     * 
     * @var array
     */
    private $container;

    /**
     * Initialize the container property.
     */
    public function __construct(array $data = [])
    {
        $this->container = $data;
    }

    /**
     * Return the container array.
     * 
     * @return array
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Return an array iterator for
     * the container array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->container);
    }

    /**
     * Check if an offset exists in the container.
     *
     * @param mixed $offset
     * 
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Get a value from the container.
     *
     * @param mixed $offset
     
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null; 
    }

    /**
     * Set a value in the container.
     *
     * @param mixed $offset
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    /**
     * Unset an offset from the container.
     *
     * @param mixed $offset
     * 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Set the container array.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function setContainer(array $data)
    {
        $this->container = $data;
    }
}
