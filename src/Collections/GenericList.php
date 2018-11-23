<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Checker;
use PHPCollections\Exceptions\InvalidOperationException;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\MergeableInterface;
use PHPCollections\Interfaces\ObjectCollectionInterface;
use PHPCollections\Interfaces\SortableInterface;

/**
 * A list for a generic type of data.
 */
class GenericList extends AbstractCollection implements ObjectCollectionInterface, IterableInterface, MergeableInterface, SortableInterface
{
    /**
     * The error message to show when
     * someone try to store a value of a
     * different type than the specified
     * in the type property.
     *
     * @var string
     */
    private $error;

    /**
     * The type of data that
     * will be stored.
     *
     * @var string
     */
    private $type;

    /**
     * Creates a new GenericList.
     *
     * @param string $type
     * @param array  $data
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $type, object ...$data)
    {
        $this->type = $type;
        $this->error = "The type specified for this collection is {$type}, you cannot pass an object of type %s";

        foreach ($data as $value) {
            Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));
        }

        parent::__construct($data);
    }

    /**
     * Adds a new object to the collection.
     *
     * @param object $value
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function add(object $value): void
    {
        Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));

        $this->store->offsetSet($this->store->count(), $value);
    }

    /**
     * Gets the difference between two GenericList.
     *
     * @param \PHPCollections\Collections\GenericList $newGenericList
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\Collections\GenericList
     */
    public function diff(AbstractCollection $newGenericList): AbstractCollection
    {
        if (!$newGenericList instanceof self) {
            throw new InvalidOperationException('You should only compare a GenericList against another GenericList');
        }

        if ($this->type !== $newGenericList->getType()) {
            throw new InvalidOperationException("This is a collection of {$this->type} objects, you cannot pass a collection of {$newGenericList->getType()} objects");
        }

        $diffValues = array_udiff($this->toArray(), $newGenericList->toArray(), function ($firstValue, $secondValue) {
            return $firstValue <=> $secondValue;
        });

        return new self($this->type, ...$diffValues);
    }

    /**
     * Determines if two GenericList objects are equal.
     *
     * @param object $newGenericList
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function equals(object $newGenericList): bool
    {
        if (!$newGenericList instanceof self) {
            throw new InvalidOperationException('You should only compare an GenericList against another GenericList');
        }

        return $this->toArray() == $newGenericList->toArray();
    }

    /**
     * Returns all the coincidences found
     * for the given callback or null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function filter(callable $callback): ?self
    {
        $matcheds = [];

        foreach ($this->store as $key => $value) {
            if (call_user_func($callback, $key, $value) === true) {
                $matcheds[] = $value;
            }
        }

        return count($matcheds) > 0 ? new $this($this->type, ...array_values($matcheds)) : null;
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
     * Returns the object at the specified index
     * or null if it's not defined.
     *
     * @param int $offset
     *
     * @throws \OutOfRangeException
     *
     * @return object
     */
    public function get(int $offset): object
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection.');
        }

        if (!$this->store->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index do not exits for this collection.', $offset));
        }

        return $this->store->offsetGet($offset);
    }

    /**
     * Returns the type property.
     *
     * @return string
     */
    private function getType(): string
    {
        return $this->type;
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function map(callable $callback): ?self
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this($this->type, ...array_values($matcheds)) : null;
    }

    /**
     * Merges two GenericList into a new one.
     *
     * @param array $data
     *
     * @throws \InvalidArgumentException
     *
     * @return \PHPCollections\Collections\GenericList
     */
    public function merge(AbstractCollection $newGenericList): AbstractCollection
    {
        $newGenericList->forEach(function ($value) {
            Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));
        });

        return new $this($this->type, ...array_merge($this->toArray(), $newGenericList->toArray()));
    }

    /**
     * Returns a random element from
     * the collection.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return mixed
     */
    public function rand()
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot get a random element from an empty collection.');
        }

        $randomIndex = array_rand($this->toArray());

        return $this->get($randomIndex);
    }

    /**
     * Removes an item from the collection
     * and repopulate the data container.
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
            throw new OutOfRangeException('You\'re trying to remove data into a empty collection.');
        }

        if (!$this->store->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index do not exits for this collection.', $offset));
        }

        $this->store->offsetUnset($offset);
        $this->repopulate();
    }

    /**
     * Repopulates the data container.
     *
     * @return void
     */
    private function repopulate(): void
    {
        $oldData = array_values($this->toArray());
        $this->store->setContainer($oldData);
    }

    /**
     * Returns a new collection with the
     * reversed values.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\Collections\GenericList
     */
    public function reverse(): self
    {
        if ($this->isEmpty()) {
            throw new InvalidOperationException('You cannot reverse an empty collection.');
        }

        return new $this($this->type, ...array_reverse($this->toArray()));
    }

    /**
     * Returns a portion of the GenericList.
     *
     * @param int      $offset
     * @param int|null $length
     *
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function slice(int $offset, ?int $length = null): ?AbstractCollection
    {
        $newData = array_slice($this->toArray(), $offset, $length);

        return count($newData) > 0 ? new self($this->type, ...$newData) : null;
    }

    /**
     * Returns a new GenericList with the
     * values ordered by a given callback
     * if couldn't sort returns null.
     *
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function sort(callable $callback): ?AbstractCollection
    {
        $data = $this->toArray();

        return usort($data, $callback) ? new $this($this->type, ...$data) : null;
    }

    /**
     * Updates the value of the element
     * at the given index.
     *
     * @param int   $index
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function update(int $index, object $value): bool
    {
        Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));

        if (!$this->exists($index)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->store[$index] = $value;

        return $this->store[$index] === $value;
    }
}
