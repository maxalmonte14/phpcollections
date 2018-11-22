<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use Countable;
use JsonSerializable;
use OutOfRangeException;
use PHPCollections\Store;
use PHPCollections\Exceptions\InvalidOperationException;

/**
 * The base class for countable and
 * JSON serializable collections.
 */
abstract class AbstractCollection implements Countable, JsonSerializable
{
    /**
     * The data container.
     *
     * @var \PHPCollections\Store
     */
    protected $store;

    /**
     * Initializes the store property.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->store = new Store($data);
    }

    /**
     * Reinitializes the store property.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->store = new Store();
    }

    /**
     * Checks if the collection
     * contains a given value.
     *
     * @param mixed $needle
     *
     * @return bool
     */
    public function contains($needle): bool
    {
        return in_array($needle, $this->toArray());
    }

    /**
     * Returns the length of the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->store->count();
    }

    /**
     * Gets the difference between two collections.
     *
     * @param \PHPCollections\Collections\AbstractCollection $collection
     *
     * @return \PHPCollections\Collections\AbstractCollection
     */
    abstract public function diff(self $collection): self;

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
        return $this->store->offsetExists($offset);
    }

    /**
     * Determines if two collections are equal.
     *
     * @param \PHPCollections\Collections\AbstractCollection $collection
     *
     * @return bool
     */
    abstract public function equals(self $collection): bool;

    /**
     * Fills the collection with a set of data.
     *
     * @param array $data
     *
     * @return void
     */
    public function fill(array $data): void
    {
        foreach ($data as $entry) {
            $this->add($entry);
        }
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
     * Returns a portion of the collection.
     *
     * @param int      $offset
     * @param int|null $lenght
     *
     * @return \PHPCollections\Collections\AbstractCollection
     */
    abstract public function slice(int $offset, ?int $lenght): ?self;

    /**
     * Returns the sum of a set of values.
     *
     * @param callable $callback
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return float
     */
    public function sum(callable $callback): float
    {
        $sum = 0;

        foreach ($this->store as $value) {
            if (!is_numeric($result = call_user_func($callback, $value))) {
                throw new InvalidOperationException('You cannot sum non-numeric values');
            }

            $sum += $result;
        }

        return $sum;
    }

    /**
     * Returns a plain array with
     * your collection data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->store->getContainer();
    }
}
