<?php

namespace PHPCollections\Interfaces;

interface CollectionInterface
{
    public function add($value);
    
    public function get($offset);

    public function remove($offset);

    public function update($index, $value);    
}
