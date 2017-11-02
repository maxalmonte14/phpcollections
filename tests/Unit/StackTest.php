<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPCollections\Collections\Stack;

class StackTest extends TestCase
{
    private $stack;

    public function setUp()
    {
        $this->stack = new Stack('string');
        $this->stack->push('John');
        $this->stack->push('Harold');
        $this->stack->push('Sameen');
        $this->stack->push('Joss');
        $this->stack->push('Cal');
        $this->stack->push('Peter');
        $this->stack->push('Samantha');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function cannotPushUncompatibleValueToStack()
    {
        $this->stack->push(['color' => 'green']);
    }

    /** @test */
    public function canPushAnElement()
    {
        $newElement = $this->stack->push('Zoey');
        $this->assertEquals($newElement, $this->stack->peek());
    }

    /** @test */
    public function canPeekLastElement()
    {
        $lastElement = $this->stack->peek();
        $this->assertEquals('Samantha', $lastElement);
    }

    /** @test */
    public function canPopLastElement()
    {
        $lastElement = $this->stack->pop();
        $this->assertEquals('Samantha', $lastElement);
        $this->assertEquals('Peter', $this->stack->peek());
    }

    /** @test */
    public function canCountTheElements()
    {
        $this->assertCount(7, $this->stack);
    }

    /** @test */
    public function canCheckIfTheStackIsEmpty()
    {
        $newStack = new Stack('string');
        $this->assertTrue($newStack->isEmpty());
        $this->assertFalse($this->stack->isEmpty());
    }

    /** @test */
    public function canClearStack()
    {
        $this->stack->clear();
        $this->assertTrue($this->stack->isEmpty());
    }
}
