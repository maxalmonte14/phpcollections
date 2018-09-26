<?php

namespace PHPCollections\Collections;

use Countable;
use JsonSerializable;
use PHPCollections\DataHolder;

/**
 * The base for iterable, countable
 * and arrayable collections.
 */
abstract class BaseCollection implements Countable, JsonSerializable
{
    /**
     * The data container.
     *
     * @var \PHPCollections\DataHolder
     */
    protected $dataHolder;

    /**
     * Represents the index of the data array.
     *
     * @var int
     */
    private $position = 0;

    /**
     * BaseCollection constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->dataHolder = new DataHolder($data);
    }

    /**
     * Remove all the elements
     * of the data array.
     *
     * @return void
     */
    public function clear()
    {
        $this->dataHolder = new DataHolder();
    }

    /**
     * Return the length of the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->toArray());
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
        return $this->dataHolder->offsetExists($offset);
    }

    /**
     * Defines the behavior of the collection
     * when json_encode is called.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Returns a plain array with
     * your dictionary data.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->dataHolder->getContainer();
    }
}
