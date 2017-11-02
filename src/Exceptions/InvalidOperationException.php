<?php

namespace PHPCollections\Exceptions;

use Exception;

class InvalidOperationException extends Exception
{
    /**
     * Return the string representation
     * of the Exception
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: [%d]: %s', __CLASS__, $this->code, $this->message);
    }
}
