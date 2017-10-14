<?php

namespace PHPCollections\Collections;

class Pair {

    /**
     * The key for the Pair object
     *
     * @var mixed
     */
    private $key;

    /**
     * The value for the Pair object
     *
     * @var mixed
     */
    private $value;

    /**
     * The Pair class constructor
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Allow access to the key 
     * property by its value
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($name == $this->key)
            return $this->value;
    }

    /**
     * Return the key property
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Return the value property
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the value property
     *
     * @param  mixed $value
     * @return void
     */
    public function setValue($value)
    {
        if (!is_null($value))
            $this->value = $value;
    }

}