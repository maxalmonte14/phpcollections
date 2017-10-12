<?php

namespace PHPCollections;

use ArrayObject;
use InvalidArgumentException;

class Dictionary extends ArrayObject
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
        foreach ($this as $key => $value)
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
     * Returns a plain array with
     * your dictionary data
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this;
    }
}