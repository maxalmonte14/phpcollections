<?php

namespace PHPCollections\Collections;

use ArrayObject;
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
        parent::__construct($data);
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
        $this->offsetSet($key, $value);
    }

    /**
     * Determine if the passed data is
     * of the type specified in the type
     * attribute, if not raise and Exception
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
     * Remove all the elements
     *
     * @return void
     */
    public function clear()
    {
        foreach ($this->toArray() as $key => $value)
            $this->offsetUnset($key);
    }

    /**
     * Check if exists a value
     *  with the given key
     *
     * @param  mixed $key
     * @return void
     */
    public function exists($key)
    {
        return $this->offsetExists($key);
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
            if (call_user_func($callback, $key, $value) === true)
                $matcheds[$key] = $value;
        }
        return count($matcheds) > 0 ? new $this($this->keyType, $this->valueType, $matcheds) : null;
    }

    /**
     * Find an element based on a given callback
     *
     * @param  callable $callback
     * @return void
     */
    public function find(callable $callback)
    {
        foreach ($this as $key => $value) {
            if ($callback($value, $key) === true) {
                $matched = $value;
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
        foreach ($this as $key => $value) return $this->get($key);
    }

    /**
     * Return the value for the specified
     * key or null if it's not defined
     *
     * @param  mixed $key
     * @return void
     */
    public function get($key)
    {
        return $this->offsetExists($key) ? $this->offsetGet($key) : null;
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
     * Remove a value from the dictionary
     *
     * @param  mixed $key
     * @return void
     */
    public function remove($key)
    {
        if ($this->offsetExists($key))
            $this->offsetUnset($key);
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
}