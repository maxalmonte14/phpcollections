<?php

namespace PHPCollections\Interfaces;

interface SortableInterface
{
    public function sort(callable $callback);
}
