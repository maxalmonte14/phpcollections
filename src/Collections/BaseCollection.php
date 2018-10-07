<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use Countable;
use JsonSerializable;
use OutOfRangeException;
use PHPCollections\DataHolder;

/**
 * The base class for countable and
 * JSON serializable collections.
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
     * Initializes the dataHolder property.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->dataHolder = new DataHolder($data);
    }

    /**
     * Reinitializes the dataHolder property.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->dataHolder = new DataHolder();
    }

    /**
     * Returns the length of the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->toArray());
    }

    /**
     * Checks if the given index
     * exists in the collection.
     *
     * @param mixed $offset
     * 
     * @return bool
     */
    public function exists($offset): bool
    {
        return $this->dataHolder->offsetExists($offset);
    }

    /**
     * Gets the first element in the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function first()
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection');
        }

        return array_values($this->toArray())[0];
    }

    /**
     * Checks if the collection is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Defines the behavior of the collection
     * when json_encode is called.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Gets the last element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function last()
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection');
        }

        return array_values($this->toArray())[$this->count() - 1];
    }

    /**
     * Returns a plain array with
     * your dictionary data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->dataHolder->getContainer();
    }
}
