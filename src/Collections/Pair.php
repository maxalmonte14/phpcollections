<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

/**
 * A simple key / value pair
 * object representation.
 */
class Pair
{
    /**
     * The key for the Pair object.
     *
     * @var mixed
     */
    private $key;

    /**
     * The value for the Pair object.
     *
     * @var mixed
     */
    private $value;

    /**
     * Initializes class properties.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Allows access to the key
     * property by its value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($name === $this->key) {
            return $this->value;
        }
    }

    /**
     * Returns the key property.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Returns the value property.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of the value property.
     *
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
