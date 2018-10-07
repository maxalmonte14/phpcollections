<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

use PHPCollections\Collections\BaseCollection;

interface SortableInterface
{
    public function sort(callable $callback): ?BaseCollection;
}
