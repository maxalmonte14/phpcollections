<?php

namespace PHPCollections\Interfaces;

interface ComparableInterface
{
    public function equals(object $object): bool;
}