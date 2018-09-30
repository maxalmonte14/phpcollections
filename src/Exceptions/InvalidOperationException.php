<?php

declare(strict_types=1);

namespace PHPCollections\Exceptions;

use Exception;

/**
 * An Exception for representing
 * invalid operations with collections.
 */
class InvalidOperationException extends Exception
{
    /**
     * Returns the string representation
     * of the Exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: [%d]: %s', __CLASS__, $this->code, $this->message);
    }
}
