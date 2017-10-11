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
        $this->list->add(new \ArrayObject(['name' => 'Carter']));
        $this->list->add(new \ArrayObject(['name' => 'Kara']));
        $this->list->add(new \ArrayObject(['name' => 'Snow']));
        $this->list->add(new \ArrayObject(['name' => 'Zoey']));
        $this->list->add(new \ArrayObject(['name' => 'Cal']));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddToList()
    {
        $this->assertCount(8, $this->list);
        $this->list->add(new \Exception());
    }

    public function testClearList()
    {
        $this->list->clear();
        $this->assertCount(0, $this->list);
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
        $this->list->get(9); // Here an OutOfRangeException is thrown!
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testRemoveFromList()
    {
        $this->list->remove(0);
        $this->assertCount(7, $this->list);
        $arrayObject = $this->list->get(0);
        $this->assertNotEquals('John', $arrayObject->offsetGet('name'));
        $this->list->remove(9); // Here an OutOfRangeException is thrown!
    }

    /**
     * @expectedException ArgumentCountError
     */
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

        $oneMoreList = $this->list->filter(function ($value, $key) {
            return strlen($value['name']) <= 4;
        }, false); // Here an ArgumentCountError!
    }

    public function testSearchInList()
    {
        $newList = $this->list->search(function ($value) {
            return strlen($value['name']) > 4;
        });
        $this->assertCount(2, $newList);
        $this->assertEquals('Finch', $newList->get(0)->offsetGet('name'));

        $anotherList = $this->list->search(function ($value) {
            return strlen($value['name']) > 10;
        });
        $this->assertNull($anotherList);
    }
}