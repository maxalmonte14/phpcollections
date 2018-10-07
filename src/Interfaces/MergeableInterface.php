<?php

namespace PHPCollections\Interfaces;

use PHPCollections\Collections\BaseCollection;

interface MergeableInterface
{
    public function merge(BaseCollection $collection): BaseCollection;
}
