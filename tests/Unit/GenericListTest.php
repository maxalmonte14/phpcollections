<?php

use PHPUnit\Framework\TestCase;
use PHPCollections\GenericList;

class GenericListTest extends TestCase
{
    private $list;

    public function setUp()
    {
        $this->list = new GenericList(\ArrayObject::class);
        $this->list->add(new \ArrayObject(['name' => 'John']));
        $this->list->add(new \ArrayObject(['name' => 'Finch']));
        $this->list->add(new \ArrayObject(['name' => 'Shaw']));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddToList()
    {
        $this->assertEquals($this->list->count(), 3);
        $this->list->add(new \Exception());
    }

    public function testClearList()
    {
        $this->list->clear();
        $this->assertEquals($this->list->count(), 0);
        $this->setUp();
    }

    public function testFindIntoList()
    {
        $arrayObject = $this->list->find(function ($value) {
            return $value['name'] === 'Finch';
        });

        $this->assertEquals('Finch', $arrayObject->offsetGet('name'));
        $this->assertNotEquals('Fusco', $arrayObject->offsetGet('name'));
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testGetFromList()
    {
        $arrayObject = $this->list->get(2);
        $this->assertEquals('Shaw', $arrayObject->offsetGet('name'));
        $this->list->get(3); // Here an OutOfRangeException is thrown!
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testRemoveFromList()
    {
        $this->list->remove(0);
        $this->assertEquals(2, $this->list->count());
        $arrayObject = $this->list->get(0);
        $this->assertNotEquals('John', $arrayObject->offsetGet('name'));
        $this->list->remove(2); // Here an OutOfRangeException is thrown!
    }

    public function testFilterList()
    {
        $newList = $this->list->filter(function ($value, $key) {
            return strlen($value['name']) <= 4;
        });

        $this->assertEquals('John', $newList->get(0)->offsetGet('name'));
        $this->assertEquals('Shaw', $newList->get(1)->offsetGet('name'));

        $anotherList = $this->list->filter(function ($value, $key) {
            return strlen($value['name']) > 10;
        });

        $this->assertNull($anotherList);
    }
}