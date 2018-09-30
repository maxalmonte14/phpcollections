<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

interface IterableInterface
{
    public function forEach(callable $callback): void;
}
