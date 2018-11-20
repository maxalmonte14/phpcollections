<?php

namespace PHPCollections\Interfaces;

use PHPCollections\Collections\AbstractCollection;

interface MergeableInterface
{
    public function merge(AbstractCollection $collection): AbstractCollection;
}
