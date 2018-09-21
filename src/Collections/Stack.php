<?php

namespace PHPCollections\Collections;

use Countable;
use InvalidArgumentException;

/**
 * A generic LIFO Stack.
 */
class Stack implements Countable
{
    /**
     * The data container
     *
     * @var array
     */
    private $data;

    /**
     * The type of the values
     * for this Stack
     *
     * @var mixed
     */
    private $type;

    /**
     * The Stack class constructor
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Determine if the passed value is
     * of the type specified in the type
     * attribute, if not raise and Exception.
     *
     * @param  mixed $value
     * @throws \InvalidArgumentException
     * 
     * @return void
     */
    private function checkType($value)
    {
        $type = is_object($value) ? get_class($value) : gettype($value);

        if ($type != $this->type) {
            throw new InvalidArgumentException(
                sprintf('The type specified for this collection is %s, you cannot pass a value of type %s', $this->type, $type)
            );
        }
    }

    /**
     * Clear the data values.
     *
     * @return void
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Returns the length of the Stack.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Check if the stack is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Get the element at
     * the end of the Stack.
     *
     * @return mixed
     */
    public function peek()
    {
        return $this->data[$this->count() - 1];
    }

    /**
     * Pop the element at
     * the end of the stack.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Add a new element at
     * the end of the Stack.
     *
     * @param  mixed $value
     * 
     * @return void
     */
    public function push($value)
    {
        $this->checkType($value);

        $this->data[] = $value;
        
        return $value;
    }
}
