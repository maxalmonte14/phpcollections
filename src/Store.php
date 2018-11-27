<?php

declare(strict_types=1);

namespace PHPCollections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * A class for storing and managing data.
 */
class Store implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The array for storing data.
     *
     * @var array
     */
    private $container;

    /**
     * Initializes the container property.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->container = $data;
    }

    /**
     * Returns the number of elements
     * in the container array.
     *
     * @return int
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * Returns the first element of the
     * container array.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->container);
    }

    /**
     * Returns the container array.
     *
     * @return array
     */
    public function getContainer(): array
    {
        return $this->container;
    }

    /**
     * Returns an array iterator for
     * the container property.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->container);
    }

    /**
     * Returns the last element of the
     * container array.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->container);
    }

    /**
     * Checks if an offset exists in the container.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets a value from the container.
     *
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets a value into the container.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->container[$offset] = $value;
    }

    /**
     * Unsets an offset from the container.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Sets the container array.
     *
     * @param array $data
     *
     * @return void
     */
    public function setContainer(array $data): void
    {
        $this->container = $data;
    }
}
