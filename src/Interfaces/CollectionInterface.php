<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

interface CollectionInterface
{
    public function add($value): void;

    public function get(int $offset);

    public function remove(int $offset): void;

    public function update(int $offset, $value): bool;
}
