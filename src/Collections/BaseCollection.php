<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use Countable;
use JsonSerializable;
use PHPCollections\DataHolder;

/**
 * The base for countable and
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
     * Represents the index of the data array.
     *
     * @var int
     */
    private $position = 0;

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
