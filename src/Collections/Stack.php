<?php

declare(strict_types=1);

namespace PHPCollections\Collections;

use Countable;
use InvalidArgumentException;

/**
 * A generic LIFO Stack.
 */
class Stack implements Countable
{
    /**
     * The data container.
     *
     * @var array
     */
    private $data;

    /**
     * The type of the values
     * for this Stack.
     *
     * @var mixed
     */
    private $type;

    /**
     * Initialize class properties.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->data = [];
        $this->type = $type;
    }

    /**
     * Determines if the passed value is
     * of the type specified in the type
     * attribute, if not raises and Exception.
     *
     * @param  mixed $value
     * @throws \InvalidArgumentException
     * 
     * @return void
     */
    private function checkType($value): void
    {
        $type = is_object($value) ? get_class($value) : gettype($value);

        if ($type != $this->type) {
            throw new InvalidArgumentException(
                sprintf(
                    'The type specified for this collection is %s, you cannot pass a value of type %s',
                    $this->type,
                    $type
                )
            );
        }
    }

    /**
     * Clears the data values.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Returns the length of the Stack.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Checks if the stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Gets the element at
     * the end of the Stack.
     *
     * @return mixed
     */
    public function peek()
    {
        return $this->data[$this->count() - 1];
    }

    /**
     * Pops the element at
     * the end of the stack.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Adds a new element at
     * the end of the Stack.
     *
     * @param mixed $value
     * 
     * @return mixed
     */
    public function push($value)
    {
        $this->checkType($value);

        $this->data[] = $value;
        
        return $value;
    }
}
