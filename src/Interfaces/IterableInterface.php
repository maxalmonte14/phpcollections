<?php

namespace PHPCollections\Interfaces;

interface IterableInterface
{
    public function forEach(callable $callback);
}
