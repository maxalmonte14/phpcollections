<?php

namespace PHPCollections\Collections;

use InvalidArgumentException;
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
     * Initialize the class properties.
     *
     * @param mixed $keyType
     * @param mixed $valueType
     * @param array $data
     */
    public function __construct($keyType, $valueType, array $data = [])
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
        
        parent::__construct($data);
        $this->initializePairs($data);
    }

    /**
     * Add a new value to the dictionary.
     *
     * @param mixed $key
     * @param mixed $value
     * 
     * @return void
     */
    public function add($key, $value)
    {
        $this->checkType(['key' => $key, 'value' => $value]);
        $this->dataHolder->offsetSet($key, new Pair($key, $value));
    }

    /**
     * Determine if the passed data is
     * of the type specified in the keyType/valueType
     * attribute, if not throws and Exception.
     *
     * @param mixed $data
     * @throws \InvalidArgumentException
     * 
     * @return void
     */
    private function checkType(array $values)
    {
        foreach ($values as $key => $value) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            $toEval = $key == 'key' ? $this->keyType : $this->valueType;

            if ($type != $toEval) {
                throw new InvalidArgumentException(
                    sprintf('The %s type specified for this dictionary is %s, you cannot pass %s %s', $key, $toEval, getArticle($type), $type)
                );
            }
        }
    }

    /**
     * Filter the collection applying
     * a given callback.
     *
     * @param callable $callback
     * 
     * @return PHPCollections\Collections\Dictionary|null
     */
    public function filter(callable $callback)
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
     * Find an element based on a given callback.
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
     * Return the first element in the collection.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return mixed
     */
    public function first()
    {
        if ($this->count() == 0) {
            throw new InvalidOperationException('You cannot get the first element of an empty collection');
        }

        foreach ($this->dataHolder as $key => $value) {
            return $this->get($key);
        }
    }

    /**
     * Iterate over every element of the collection.
     *
     * @param callable $callback
     * 
     * @return void
     */
    public function forEach(callable $callback)
    {
        $data = $this->toArray();

        array_walk($data, $callback);
        $this->initializePairs($data);
    }

    /**
     * Return the value for the specified
     * key or null if it's not defined.
     *
     * @param mixed $key
     * 
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->dataHolder->offsetExists($key) ? $this->dataHolder->offsetGet($key)->getValue() : null;
    }

    /**
     * Return the key type of this collection.
     *
     * @return mixed
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * Return the key value of this collection.
     *
     * @return mixed
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    private function initializePairs(array $data)
    {
        foreach ($data as $key => $value) {
            $this->dataHolder[$key] = new Pair($key, $value);
        }
    }

    /**
     * Returns the last element of
     * the collection.
     *
     * @throws \PHPCollections\Exceptions\InvalidOperationException
     * 
     * @return mixed
     */
    public function last()
    {
        if ($this->count() == 0) {
            throw new InvalidOperationException('You cannot get the last element of an empty collection');
        }

        $values = array_values($this->toArray());
        
        return $values[$this->count() - 1];
    }

    /**
     * Update elements in the collection by
     * applying a given callback function.
     *
     * @param callable $callback
     * 
     * @return \PHPCollections\Collections\Dictionary|null
     */
    public function map(callable $callback)
    {
        $matcheds = array_map($callback, $this->toArray());

        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $this->toArray()) : null;
    }

    /**
     * Merges two dictionaries into a new one.
     *
     * @param \PHPCollections\Collections\Dictionary $newDictionary
     * 
     * @return \PHPCollections\Collections\Dictionary
     */
    public function merge(Dictionary $newDictionary)
    {
        foreach ($newDictionary->toArray() as $key => $value) {
            $this->checkType(['key' => $key, 'value' => $value]);
        }

        return new $this($this->keyType, $this->valueType, array_merge($this->toArray(), $newDictionary->toArray()));
    }

    /**
     * Remove a value from the dictionary.
     *
     * @param mixed $key
     * 
     * @return bool
     */
    public function remove($key)
    {
        $exits = $this->dataHolder->offsetExists($key);

        if ($exits) {
            $this->dataHolder->offsetUnset($key);
        }

        return $exits;
    }

    /**
     * Sort collection data by values
     * applying a given callback.
     *
     * @param callable $callback
     * 
     * @return bool
     */
    public function sort(callable $callback)
    {
        $data = $this->toArray();

        return usort($data, $callback) ? new $this($this->keyType, $this->valueType, $data) : null;
    }

    /**
     * Returns an array representation
     * of your dictionary data.
     *
     * @return array
     */
    public function toArray()
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
     * @return array
     */
    public function toJson()
    {
        return json_encode($this->dataHolder);
    }

    /**
     * Update the value of one Pair
     * in the collection.
     *
     * @param mixed $key
     * @param mixed $value
     * 
     * @return bool
     */
    public function update($key, $value)
    {
        $this->checkType(['key' => $key, 'value' => $value]);

        if (!$this->dataHolder->offsetExists($key)) {
            throw new InvalidOperationException('You cannot update a non-existent value');
        }

        $this->dataHolder[$key]->setValue($value);
        
        return $this->dataHolder[$key]->getValue() === $value;
    }
}
