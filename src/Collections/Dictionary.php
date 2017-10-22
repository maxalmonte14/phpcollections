<?php

namespace PHPCollections\Collections;

use InvalidArgumentException;
use PHPCollections\Exceptions\InvalidOperationException;

class Dictionary extends BaseCollection
{
    /**
     * The type of the keys
     * for this dictionary
     * 
     * @var mixed
     */
    private $keyType;

    /**
     * The type of the values
     * for this dictionary
     *
     * @var mixed
     */
    private $valueType;

    /**
     * The Dictionary class constructor
     *
     * @param mixed $keyType
     * @param mixed $valueType
     * @param array $data
     */
    public function __construct($keyType, $valueType, array $data = [])
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
        
        foreach ($data as $key => $value)
            $this->data[$key] = new Pair($key, $value);
    }

    /**
     * Add a new value to the dictionary
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function add($key, $value)
    {
        $this->checkType(['key' => $key, 'value' => $value]);
        $this->offsetSet($key, new Pair($key, $value));
    }

    /**
     * Determine if the passed data is
     * of the type specified in the keyType/valueType
     * attribute, if not throws and Exception
     *
     * @param  mixed $data
     * @throws InvalidArgumentException     
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
     * a given callback
     *
     * @param  callable $callback
     * @return PHPCollections\Collections\Dictionary|null
     */
    public function filter(callable $callback)
    {
        $matcheds = [];
        foreach ($this->data as $key => $value) {
            if (call_user_func($callback, $value->getKey(), $value->getValue()) === true)
                $matcheds[$value->getKey()] = $value->getValue();
        }
        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $matcheds) : null;
    }

    /**
     * Find an element based on a given callback
     *
     * @param  callable   $callback
     * @return mixed|null
     */
    public function find(callable $callback)
    {
        foreach ($this->data as $pair) {
            if ($callback($pair->getValue(), $pair->getKey()) === true) {
                $matched = $pair->getValue();
                break;
            }
        }
        return $matched ?? null;
    }

    /**
     * Return the first element in the collection
     *
     * @throws InvalidOperationException
     * @return mixed
     */
    public function first()
    {
        if ($this->count() == 0)
            throw new InvalidOperationException('You cannot get the first element of an empty collection');
        foreach ($this->data as $key => $value) return $this->get($key);
    }

    /**
     * Return the value for the specified
     * key or null if it's not defined
     *
     * @param  mixed  $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->offsetExists($key) ? $this->offsetGet($key)->getValue() : null;
    }

    /**
     * Return the key type of this collection
     *
     * @return mixed
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * Return the key value of this collection
     *
     * @return mixed
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * Returns the last element of
     * the collection
     *
     * @throws InvalidOperationException
     * @return mixed
     */
    public function last()
    {
        if ($this->count() == 0)
            throw new InvalidOperationException('You cannot get the last element of an empty collection');
        $values = array_values($this->toArray());
        return $values[$this->count() - 1];
    }

    /**
     * Update elements in the collection by
     * applying a given callback function
     *
     * @param  callable $callback
     * @return PHPCollections\Dictionary|null
     */
    public function map(callable $callback)
    {
        $matcheds = array_map($callback, $this->toArray());
        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $this->toArray()) : null;
    }

    /**
     * Merges two dictionaries into a new one
     *
     * @param  PHPCollections\Dictionary $newDictionary
     * @return PHPCollections\Dictionary
     */
    public function merge(Dictionary $newDictionary)
    {
        foreach ($newDictionary->toArray() as $key => $value) 
            $this->checkType(['key' => $key, 'value' => $value]);
        return new $this($this->keyType, $this->valueType, array_merge($this->data, $newDictionary->toArray()));
    }

    /**
     * Remove a value from the dictionary
     *
     * @param  mixed $key
     * @return bool
     */
    public function remove($key)
    {
        $exits = $this->offsetExists($key);
        if ($exits) $this->offsetUnset($key);
        return $exits;
    }

    /**
     * Sort collection data by values
     * applying a given callback
     * 
     * @param  callable $callback
     * @return bool
     */
    public function sort(callable $callback)
    {
        return usort($this->data, $callback);
    }

    /**
     * Returns an array representation
     * of your dictionary data
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->data as $pair)
            $array[$pair->getKey()] = $pair->getValue();
        return $array;
    }

    /**
     * Returns a JSON representation
     * of your dictionary data
     *
     * @return array
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * Update the value of one Pair 
     * in the collection
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function update($key, $value)
    {
        $this->checkType(['key' => $key, 'value' => $value]);
        if (!$this->offsetExists($key))
            throw new InvalidOperationException('You cannot update a non-existent value');
        $this->data[$key]->setValue($value);
    }
}