<?php

namespace PHPCollections\Interfaces;

interface MergeableInterface
{
    public function merge(object $collection): object;
}
