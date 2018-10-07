<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use InvalidArgumentException;
use PHPCollections\Checker;
use PHPCollections\Interfaces\IterableInterface;
use PHPCollections\Interfaces\SortableInterface;
use PHPCollections\Interfaces\ObjectCollectionInterface;
use PHPCollections\Exceptions\InvalidOperationException;

/**
 * A list for a generic type of data.
 */
class GenericList extends BaseCollection implements ObjectCollectionInterface, IterableInterface, SortableInterface
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
     * @param array $data
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
     * @param mixed $value
     * @throws \InvalidArgumentException
     * 
     * @return void
     */
    public function add($value): void
    {
        Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));

        $data = $this->toArray();

        array_push($data, $value);
        $this->dataHolder->setContainer($data);
    }

    /**
     * Returns all the coincidences found
     * for the given callback or null.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function filter(callable $callback): ?GenericList
    {
        $matcheds = [];

        foreach ($this->dataHolder as $key => $value) {
            if (call_user_func($callback, $key, $value) === true) {
                $matcheds[] = $value;
            }
        }
        
        return count($matcheds) > 0 ? new $this($this->type, ...array_values($matcheds)) : null;
    }

    /**
     * Returns the first element that
     * matches whith the callback criteria.
     *
     * @param callable $callback
     * 
     * @return mixed
     */
    public function find(callable $callback)
    {
        $dataset = $this->search($callback, true);

        return $dataset->get(0) ?? null;
    }

    /**
     * Gets the first element of the collection.
     *
     * @throws \OutOfRangeException
     * 
     * @return mixed
     */
    public function first()
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to get data into an empty collection.');
        }

        return $this->dataHolder[0];
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
        $this->dataHolder->setContainer($data);
    }

    /**
     * Returns the object at the specified index
     * or null if it's not defined.
     *
     * @param int $offset.
     * @throws \OutOfRangeException
     * 
     * @return object
     */
    public function get(int $offset): object
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection.');
        }
        
        if (! $this->dataHolder->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index do not exits for this collection.', $offset));
        }

        return $this->dataHolder->offsetGet($offset);
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
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to get data from an empty collection.');
        }

        return $this->dataHolder[$this->count() - 1];
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\Collections\GenericList|null
     */
    public function map(callable $callback): ?GenericList
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this($this->type, ...array_values($matcheds)) : null;
    }

    /**
     * Merges new data with the actual
     * collection and returns a new one.
     *
     * @param array $data
     * @throws \InvalidArgumentException
     * 
     * @return \PHPCollections\Collections\GenericList
     */
    public function merge(array $data): GenericList
    {
        foreach ($data as $value) {
            Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));
        }

        return new $this($this->type, ...array_merge($this->toArray(), $data));
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
        if ($this->count() === 0) {
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
     * @throws \OutOfRangeException
     * 
     * @return void
     */
    public function remove(int $offset): void
    {
        if ($this->count() === 0) {
            throw new OutOfRangeException('You\'re trying to remove data into a empty collection.');
        }
        
        if (! $this->dataHolder->offsetExists($offset)) {
            throw new OutOfRangeException(sprintf('The %d index do not exits for this collection.', $offset));
        }

        $this->dataHolder->offsetUnset($offset);
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
        $this->dataHolder->setContainer($oldData);
    }

    /**
     * Returns a new collection with the
     * reversed values.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return \PHPCollections\Collections\GenericList
     */
    public function reverse(): GenericList
    {
        if ($this->count() === 0) {
            throw new InvalidOperationException('You cannot reverse an empty collection.');
        }

        return new $this($this->type, ...array_reverse($this->toArray()));
    }

    /**
     * Searches one or more elements in
     * the collection.
     *
     * @param callable $callback
     * @param boolean $shouldStop
     * 
     * @return PHPCollections\GenericList|null
     */
    public function search(callable $callback, bool $shouldStop = false): ?GenericList
    {
        $matcheds = [];

        foreach ($this->dataHolder as $key => $item) {
            if ($callback($item, $key) === true) {
                $matcheds[] = $item;
                if ($shouldStop) {
                    break;
                }
            }
        }

        return count($matcheds) > 0 ? new $this($this->type, ...$matcheds) : null;
    }

    /**
     * Sorts the collection data by values
     * applying a given callback.
     *
     * @param callable $callback
     * 
     * @return bool
     */
    public function sort(callable $callback): bool
    {
        $data = $this->toArray();
        $isSorted = usort($data, $callback);

        $this->dataHolder->setContainer($data);
        return $isSorted;
    }

    /**
     * Updates the value of the element
     * at the given index.
     *
     * @param int $index
     * @param mixed $value
     * @throws \InvalidArgumentException     
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return bool
     */
    public function update(int $index, object $value): bool
    {
        Checker::objectIsOfType($value, $this->type, sprintf($this->error, get_class($value)));

        if (! $this->exists($index)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->dataHolder[$index] = $value;
        
        return $this->dataHolder[$index] === $value;
    }
}
