<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

interface ObjectCollectionInterface
{
    public function add(object $value): void;

    public function get(int $offset): object;

    public function remove(int $offset): void;

    public function update(int $offset, object $value): bool;
}
