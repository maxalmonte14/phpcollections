<?php

declare(strict_types=1);

namespace PHPCollections;

use InvalidArgumentException;

/**
 * An utility class for checking
 * different type of data.
 */
class Checker
{
    /**
     * Checks that two values are equals.
     *
     * @param mixed  $firstValue
     * @param mixed  $secondValue
     * @param string $message
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function isEqual($firstValue, $secondValue, string $message): bool
    {
        if ($firstValue !== $secondValue) {
            throw new InvalidArgumentException($message);
        }

        return true;
    }

    /**
     * Checks that a value is and object
     * if not throws an exception.
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function isObject($value, string $message): bool
    {
        if (!is_object($value)) {
            throw new InvalidArgumentException($message);
        }

        return true;
    }

    /**
     * Checks that an object is of the desired
     * type, if not throws an exception.
     *
     * @param object $object
     * @param string $type
     * @param string $message
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function objectIsOfType(object $object, string $type, string $message): bool
    {
        if (!is_a($object, $type)) {
            throw new InvalidArgumentException($message);
        }

        return true;
    }

    /**
     * Checks that a Dictionary key or value
     * is of the desire type, if not throws
     * an exception.
     *
     * @param mixed  $value
     * @param mixed  $valueType
     * @param string $message
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function valueIsOfType($value, $valueType, string $message): bool
    {
        $newValueType = is_object($value) ? get_class($value) : gettype($value);

        if ($newValueType != $valueType) {
            throw new InvalidArgumentException($message);
        }

        return true;
    }
}
