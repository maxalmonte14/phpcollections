<?php

declare(strict_types=1);

namespace PHPCollections\Interfaces;

interface DictionaryInterface
{
    public function add($key, $value): void;

    public function get($key);

    public function remove($key): void;

    public function update($key, $value): bool;
}
