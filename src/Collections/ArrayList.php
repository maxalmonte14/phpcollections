<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Exceptions\InvalidOperationException;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\MergeableInterface;
use PHPCollections\Interfaces\SortableInterface;
use PHPCollections\Traits\ExtensibleTrait;

/**
 * A list of values of any type.
 */
class ArrayList extends AbstractCollection implements IterableInterface, MergeableInterface, SortableInterface
{

    use ExtensibleTrait;

    /**
     * Adds a new element to the collection.
     *
     * @param mixed $value
     *
     * @return void
     */
    public function add($value): void
    {
        $this->store->offsetSet($this->store->count(), $value);
    }

    /**
     * Gets the difference between two ArrayList.
     *
     * @param \PHPCollections\Collections\ArrayList $newArrayList
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\Collections\ArrayList
     */
    public function diff(AbstractCollection $newArrayList): AbstractCollection
    {
        if (!$newArrayList instanceof self) {
            throw new InvalidOperationException('You should only compare an ArrayList against another ArrayList');
        }

        $diffValues = array_udiff($this->toArray(), $newArrayList->toArray(), function ($firstValue, $secondValue) {
            if (gettype($firstValue) !== gettype($secondValue)) {
                return -1;
            }

            return $firstValue <=> $secondValue;
        });

        return new self($diffValues);
    }

    /**
     * Determines if two ArrayList objects are equal.
     *
     * @param object $newArrayList
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function equals(object $newArrayList): bool
    {
        if (!$newArrayList instanceof self) {
            throw new InvalidOperationException('You should only compare an ArrayList against another ArrayList');
        }

        return $this->toArray() == $newArrayList->toArray();
    }

    /**
     * Returns all the coincidences found
     * for the given callback or null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\ArrayList|null
     */
    public function filter(callable $callback): ?self
    {
        $matches = [];

        foreach ($this->store as $value) {
            if (call_user_func($callback, $value) === true) {
                $matches[] = $value;
            }
        }

        return count($matches) > 0 ? new $this(array_values($matches)) : null;
    }

    /**
     * Iterates over every element of the collection.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function forEach(callable $callback): void
    {
        $data = $this->toArray();

        array_walk($data, $callback);
        $this->store->setContainer($data);
    }

    /**
     * Gets the element specified
     * at the given index.
     *
     * @param int $offset
     *
     * @return mixed
     */
    public function get(int $offset)
    {
        return $this->store->offsetGet($offset);
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\ArrayList|null
     */
    public function map(callable $callback): ?self
    {
        $matches = array_map($callback, $this->toArray());

        return count($matches) > 0 ? new $this(array_values($matches)) : null;
    }

    /**
     * Merges two ArrayList into a new one.
     *
     * @param \PHPCollections\Collections\ArrayList $newArrayList
     *
     * @return \PHPCollections\Collections\ArrayList
     */
    public function merge(object $newArrayList): object
    {
        return new $this(array_merge($this->toArray(), $newArrayList->toArray()));
    }

    /**
     * Returns a random element of
     * the collection.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return mixed
     */
    public function rand()
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot get a random element from an empty collection');
        }

        $randomIndex = (int) array_rand($this->toArray());

        return $this->get($randomIndex);
    }

    /**
     * Removes an item from the collection
     * and repopulates the data array.
     *
     * @param int $offset
     *
     * @throws \OutOfRangeException
     *
     * @return void
     */
    public function remove(int $offset): void
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to remove data from an empty collection');
        }

        if (!$this->store->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index does not exists for this collection', $offset));
        }

        $this->store->offsetUnset($offset);
    }

    /**
     * Returns a new collection with the
     * reversed values.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\Collections\ArrayList
     */
    public function reverse(): self
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot reverse an empty collection');
        }

        return new $this(array_reverse($this->toArray()));
    }

    /**
     * Returns a portion of the ArrayList.
     *
     * @param int      $offset
     * @param int|null $length
     *
     * @return \PHPCollections\Collections\ArrayList|null
     */
    public function slice(int $offset, ?int $length = null): ?AbstractCollection
    {
        $newData = array_slice($this->toArray(), $offset, $length);

        return count($newData) > 0 ? new self($newData) : null;
    }

    /**
     * Returns a new ArrayList with the
     * values ordered by a given callback
     * if couldn't sort returns null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\ArrayList|null
     */
    public function sort(callable $callback): ?object
    {
        $data = $this->toArray();

        return usort($data, $callback) ? new $this($data) : null;
    }

    /**
     * Updates the value of the element
     * at the given index.
     *
     * @param int   $index
     * @param mixed $value
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function update(int $index, $value): bool
    {
        if (!$this->exists($index)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->store->offsetSet($index, $value);

        return $this->store->offsetGet($index) === $value;
    }
}
