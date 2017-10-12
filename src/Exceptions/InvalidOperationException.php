<?php

namespace PHPCollections\Exceptions;

use Exception;

class InvalidOperationException extends Exception
{
    public function __toString()
    {
        return sprintf('%s: [%d]: %s', __CLASS__, $this->code, $this->message); 
    }
}