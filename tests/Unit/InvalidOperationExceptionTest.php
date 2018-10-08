<?php

namespace Tests\Unit;

use PHPCollections\Exceptions\InvalidOperationException;
use PHPUnit\Framework\TestCase;

class InvalidOperationExceptionTest extends TestCase
{
    /**
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function testIsThrowable()
    {
        throw new InvalidOperationException('The Exception is throwable!');
    }

    public function testIsCatchable()
    {
        try {
            throw new InvalidOperationException('The Exception is catchable!');
        } catch (InvalidOperationException $e) {
            $this->assertEquals('The Exception is catchable!', $e->getMessage());
        }
    }
}
