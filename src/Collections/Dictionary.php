<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use InvalidArgumentException;
use PHPCollections\Checker;
use PHPCollections\Interfaces\SortableInterface;
use PHPCollections\Interfaces\DictionaryInterface;
use PHPCollections\Exceptions\InvalidOperationException;

/**
 * A Pair object collection
 * represented by a generic
 * type key and value.
 */
class Dictionary extends BaseCollection implements DictionaryInterface
{
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
     * @throws \InvalidArgumentException
     * 
     * @return void
     */
    public function add($key, $value): void
    {
        $this->validateEntry($key, $value);
        $this->dataHolder->offsetSet($key, new Pair($key, $value));
    }

    /**
     * Validates that a key and value are of the
     * specified types in the class.
     * 
     * @param mixed $key
     * @param mixed $value
     * @throws \InvalidArgumentException
     * 
     * @return bool
     */
    private function validateEntry($key, $value): bool
    {
        Checker::valueIsOfType(
            $key, $this->keyType,
            sprintf(
                "The %s type specified for this dictionary is %s, you cannot pass %s %s",
                'key', $this->keyType, getArticle(gettype($key)), gettype($key)
            )
        );
        Checker::valueIsOfType(
            $value, $this->valueType,
            sprintf(
                "The %s type specified for this dictionary is %s, you cannot pass %s %s",
                'value', $this->valueType, getArticle(gettype($value)), gettype($value)
            )
        );

        return true;
    }

    /**
     * Filters the collection applying
     * a given callback.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function filter(callable $callback): ?Dictionary
    {
        $matcheds = [];

        foreach ($this->dataHolder as $key => $value) {
            if (call_user_func($callback, $value->getKey(), $value->getValue()) === true) {
                $matcheds[$value->getKey()] = $value->getValue();
            }
        }

        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $matcheds) : null;
    }

    /**
     * Finds an element based on a given callback.
     *
     * @param callable $callback
     * 
     * @return mixed|null
     */
    public function find(callable $callback)
    {
        foreach ($this->dataHolder as $pair) {
            if ($callback($pair->getValue(), $pair->getKey()) === true) {
                $matched = $pair->getValue();
                break;
            }
        }

        return $matched ?? null;
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
        return $this->dataHolder->offsetExists($key) ?
               $this->dataHolder->offsetGet($key)->getValue() :
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
            $this->dataHolder[$key] = new Pair($key, $value);
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
    public function map(callable $callback): ?Dictionary
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $this->toArray()) : null;
    }

    /**
     * Merges two dictionaries into a new one.
     *
     * @param \PHPCollections\Collections\Dictionary $newDictionary
     * @throws \InvalidArgumentException
     * 
     * @return \PHPCollections\Collections\Dictionary
     */
    public function merge(Dictionary $newDictionary): Dictionary
    {
        $newDictionary->forEach(function ($value, $key) {
            $this->validateEntry($key, $value);
        });

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
     * @return bool
     */
    public function remove($key): bool
    {
        $exits = $this->dataHolder->offsetExists($key);

        if ($exits) {
            $this->dataHolder->offsetUnset($key);
        }

        return $exits;
    }

    /**
     * Sorts the collection data by values
     * applying a given callback.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function sort(callable $callback): ?Dictionary
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

        foreach ($this->dataHolder as $pair) {
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
        return json_encode($this->dataHolder);
    }

    /**
     * Updates the value of one Pair
     * in the collection.
     *
     * @param mixed $key
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return bool
     */
    public function update($key, $value): bool
    {
        $this->validateEntry($key, $value);

        if (!$this->dataHolder->offsetExists($key)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->dataHolder[$key]->setValue($value);
        
        return $this->dataHolder[$key]->getValue() === $value;
    }
}
