<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

interface SortableInterface
{
    public function sort(callable $callback): bool;
}
