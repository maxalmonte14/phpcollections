<?php

namespace Tests\Unit;

use StdClass;
use PHPCollections\Checker;
use PHPUnit\Framework\TestCase;

class CheckerTest extends TestCase
{
    /** @test */
    public function it_can_check_object_is_of_certain_type()
    {
        $isChecked = Checker::objectIsOfType(new StdClass(), 'stdClass', 'You\'re not passing a stdClass object');

        $this->assertTrue($isChecked);
    }

    /** 
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage You're not passing a stdClass object
     */
    public function it_throws_an_exception_when_object_is_not_of_certain_type()
    {
        Checker::objectIsOfType(new StdClass(), 'ArrayObject', 'You\'re not passing a stdClass object');
    }

    /** @test */
    public function it_can_check_a_value_is_an_object()
    {
        $isObject = Checker::isObject(new StdClass(), 'You\'re not passing an object');

        $this->assertTrue($isObject);
    }

    /** 
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage You're not passing an object
     */
    public function it_throws_an_exception_when_you_treat_a_primitive_like_an_object()
    {
        Checker::isObject('hello world', 'You\'re not passing an object');
    }

    /** @test */
    public function it_can_check_dictionary_value_is_of_certain_type()
    {
        $isChecked = Checker::valueIsOfType('hello world', 'string', 'You\'re not passing a string');

        $this->assertTrue($isChecked);
    }

    /** 
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage You're not passing a string
     */
    public function it_throws_an_exception_when_dictionary_value_is_not_of_certain_type()
    {
        Checker::valueIsOfType(500, 'string', 'You\'re not passing a string');
    }
}
