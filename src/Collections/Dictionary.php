<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use OutOfRangeException;
use PHPCollections\Checker;
use PHPCollections\Exceptions\InvalidOperationException;
use PHPCollections\Traits\ExtensibleTrait;

/**
 * A Pair object collection
 * represented by a generic
 * type key and value.
 */
class Dictionary extends AbstractDictionary
{
    use ExtensibleTrait;

    /**
     * The type of the keys
     * for this dictionary.
     *
     * @var mixed
     */
    private $keyType;

    /**
     * The type of the values
     * for this dictionary.
     *
     * @var mixed
     */
    private $valueType;

    /**
     * Creates a new Dictionary.
     *
     * @param mixed $keyType
     * @param mixed $valueType
     * @param array $data
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($keyType, $valueType, array $data = [])
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;

        foreach ($data as $key => $value) {
            $this->validateEntry($key, $value);
        }

        parent::__construct($data);
        $this->initializePairs($data);
    }

    /**
     * Adds a new value to the dictionary.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function add($key, $value): void
    {
        $this->validateEntry($key, $value);
        $this->store->offsetSet($key, new Pair($key, $value));
    }

    /**
     * Fills the dictionary with data.
     *
     * @param array $data
     *
     * @return void
     */
    public function fill(array $data): void
    {
        foreach ($data as $key => $entry) {
            $this->add($key, $entry);
        }
    }

    /**
     * Filters the collection applying
     * a given callback.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function filter(callable $callback): ?self
    {
        $matches = [];

        foreach ($this->store as $key => $value) {
            if (call_user_func($callback, $value->getKey(), $value->getValue()) === true) {
                $matches[$value->getKey()] = $value->getValue();
            }
        }

        return count($matches) > 0 ? new $this($this->keyType, $this->valueType, $matches) : null;
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
        $this->initializePairs($data);
    }

    /**
     * Returns the value for the specified
     * key or null if it's not defined.
     *
     * @param mixed $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->store->offsetExists($key) ?
               $this->store->offsetGet($key)->getValue() :
               null;
    }

    /**
     * Returns the key type for this collection.
     *
     * @return mixed
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * Returns the key value for this collection.
     *
     * @return mixed
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * Populates the container with Pair objects.
     *
     * @param array $data
     *
     * @return void
     */
    private function initializePairs(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->store[$key] = new Pair($key, $value);
        }
    }

    /**
     * Updates elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function map(callable $callback): ?self
    {
        $matches = array_map($callback, $this->toArray());

        return count($matches) > 0 ? new $this($this->keyType, $this->valueType, $matches) : null;
    }

    /**
     * Merges two dictionaries into a new one.
     *
     * @param \PHPCollections\Collections\Dictionary $newDictionary
     *
     * @throws \InvalidArgumentException
     *
     * @return \PHPCollections\Collections\Dictionary
     */
    public function merge(object $newDictionary): object
    {
        Checker::isEqual(
            $newDictionary->getKeyType(), $this->getKeyType(),
            sprintf('The new Dictionary key should be of type %s', $this->getKeyType())
        );
        Checker::isEqual(
            $newDictionary->getValueType(), $this->getValueType(),
            sprintf('The new Dictionary value type should be of type %s', $this->getValueType())
        );

        return new $this(
            $this->keyType,
            $this->valueType,
            array_merge($this->toArray(), $newDictionary->toArray())
        );
    }

    /**
     * Removes a value from the dictionary.
     *
     * @param mixed $key
     *
     * @throws \OutOfRangeException
     *
     * @return void
     */
    public function remove($key): void
    {
        if ($this->isEmpty()) {
            throw new OutOfRangeException('You\'re trying to remove data from an empty collection');
        }

        if (!$this->store->offsetExists($key)) {
            throw new OutOfRangeException(sprintf('The %s key does not exists for this collection', $key));
        }

        $this->store->offsetUnset($key);
    }

    /**
     * Returns a portion of the Dictionary.
     *
     * @param int      $offset
     * @param int|null $length
     *
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function slice(int $offset, ?int $length = null): ?AbstractDictionary
    {
        $newData = array_slice($this->toArray(), $offset, $length, true);

        return count($newData) > 0 ? new self($this->keyType, $this->valueType, $newData) : null;
    }

    /**
     * Returns a new Dictionary with the
     * values ordered by a given callback
     * if couldn't sort returns null.
     *
     * @param callable $callback
     *
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function sort(callable $callback): ?object
    {
        $data = $this->toArray();

        return uasort($data, $callback) ? new $this($this->keyType, $this->valueType, $data) : null;
    }

    /**
     * Returns an array representation
     * of your dictionary data.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->store as $pair) {
            $array[$pair->getKey()] = $pair->getValue();
        }

        return $array;
    }

    /**
     * Returns a JSON representation
     * of your dictionary data.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->store);
    }

    /**
     * Updates the value of one Pair
     * in the collection.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function update($key, $value): bool
    {
        $this->validateEntry($key, $value);

        if (!$this->store->offsetExists($key)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->store[$key]->setValue($value);

        return $this->store[$key]->getValue() === $value;
    }

    /**
     * Validates that a key and value are of the
     * specified types in the class.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    private function validateEntry($key, $value): bool
    {
        Checker::valueIsOfType(
            $key, $this->keyType,
            sprintf(
                'The %s type specified for this dictionary is %s, you cannot pass %s %s',
                'key', $this->keyType, getArticle(gettype($key)), gettype($key)
            )
        );
        Checker::valueIsOfType(
            $value, $this->valueType,
            sprintf(
                'The %s type specified for this dictionary is %s, you cannot pass %s %s',
                'value', $this->valueType, getArticle(gettype($value)), gettype($value)
            )
        );

        return true;
    }

    /**
     * Gets the difference between two collections.
     *
     * @param \PHPCollections\Collections\AbstractDictionary $newDictionary
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return \PHPCollections\Collections\AbstractDictionary
     */
    public function diff(AbstractDictionary $newDictionary): AbstractDictionary
    {
        if (!$newDictionary instanceof self) {
            throw new InvalidOperationException('You should only compare a Dictionary against another Dictionary');
        }

        if ($this->keyType !== $newDictionary->getKeyType()) {
            throw new InvalidOperationException("The key type for this Dictionary is {$this->keyType}, you cannot pass a Dictionary with {$newDictionary->getKeyType()} as key type");
        }

        if ($this->valueType !== $newDictionary->getValueType()) {
            throw new InvalidOperationException("The value type for this Dictionary is {$this->valueType}, you cannot pass a Dictionary with {$newDictionary->getValueType()} as value type");
        }

        return new self($this->keyType, $this->valueType, array_diff_assoc($this->toArray(), $newDictionary->toArray()));
    }

    /**
     * Determines if two Dictionary objects are equal.
     *
     * @param \PHPCollections\Collections\Dictionary $dictionary
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     *
     * @return bool
     */
    public function equals(object $dictionary): bool
    {
        if (!$dictionary instanceof self) {
            throw new InvalidOperationException('You should only compare a Dictionary against another Dictionary');
        }

        return $this->toArray() == $dictionary->toArray();
    }
}
