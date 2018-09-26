<?php

namespace PHPCollections\Interfaces;

interface DictionaryInterface
{
    public function add($key, $value);
    
    public function get($key);

    public function remove($key);

    public function update($key, $value);    
}
