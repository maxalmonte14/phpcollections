<?php

namespace Tests\Unit;

use \Exception;
use \ArrayObject;
use PHPUnit\Framework\TestCase;
use PHPCollections\Collections\GenericList;

class GenericListTest extends TestCase
{
    private $list;

    public function setUp()
    {
        $this->list = new GenericList(ArrayObject::class);
        $this->list->add(new ArrayObject(['name' => 'John']));
        $this->list->add(new ArrayObject(['name' => 'Finch']));
        $this->list->add(new ArrayObject(['name' => 'Shaw']));
        $this->list->add(new ArrayObject(['name' => 'Carter']));
        $this->list->add(new ArrayObject(['name' => 'Kara']));
        $this->list->add(new ArrayObject(['name' => 'Snow']));
        $this->list->add(new ArrayObject(['name' => 'Zoey']));
        $this->list->add(new ArrayObject(['name' => 'Cal']));
        $this->list->add(new ArrayObject(['name' => 'Lionel']));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function canAddAnElementToList()
    {
        $this->assertCount(9, $this->list);
        $this->list->add(new Exception()); // Here an InvalidArgumentException is thrown!
    }

    /** @test */
    public function canClearData()
    {
        $this->list->clear();
        $this->assertCount(0, $this->list);
    }

    /** @test */
    public function canFindOneOrMoreMatchingElements()
    {
        $arrayObject = $this->list->find(function ($value) {
            return $value['name'] === 'Finch';
        });

        $this->assertEquals('Finch', $arrayObject->offsetGet('name'));
        $this->assertNotEquals('Lionel', $arrayObject->offsetGet('name'));
    }

    /**
     * @test
     * @expectedException OutOfRangeException
     */
    public function canGetAnElementOfTheList()
    {
        $arrayObject = $this->list->get(2);
        $this->assertEquals('Shaw', $arrayObject->offsetGet('name'));
        $this->list->get(9); // Here an OutOfRangeException is thrown!
    }

    /**
     * @test
     * @expectedException OutOfRangeException
     */
    public function canRemoveAnElementOfTheList()
    {
        $this->list->remove(0);
        $this->assertCount(8, $this->list);
        $arrayObject = $this->list->get(0);
        $this->assertNotEquals('John', $arrayObject->offsetGet('name'));
        $this->list->remove(9); // Here an OutOfRangeException is thrown!
    }

    /** @test */
    public function canFilterElementsOfTheList()
    {
        $newList = $this->list->filter(function ($value, $key) {
            return strlen($value['name']) <= 4;
        });

        $this->assertEquals('John', $newList->get(0)->offsetGet('name'));
        $this->assertEquals('Finch', $newList->get(1)->offsetGet('name'));

        $anotherList = $this->list->filter(function ($value, $key) {
            return strlen($value['name']) > 10;
        });

        $this->assertNull($anotherList);
    }

    /** @test */
    public function canSearchOneOrMoreMatchingElementsOfTheList()
    {
        $newList = $this->list->search(function ($value) {
            return strlen($value['name']) > 4;
        });
        $this->assertCount(3, $newList);
        $this->assertEquals('Finch', $newList->get(0)->offsetGet('name'));

        $anotherList = $this->list->search(function ($value) {
            return strlen($value['name']) > 10;
        });
        $this->assertNull($anotherList);
    }

    /** @test */
    public function canUpdateElementsOfTheListByMapping()
    {
        $newList = $this->list->map(function ($value) {
            $value['name'] = sprintf('%s %s', 'Sr.', $value['name']);
            return $value;
        });
        $this->assertEquals('Sr. John', $newList->get(0)->offsetGet('name'));
    }

    /** @test */
    public function canSortTheList()
    {
        $isSorted = $this->list->sort(function ($a, $b) {
            return $a->offsetGet('name') <=> $b->offsetGet('name');
        });
        $this->assertTrue($isSorted);
        $this->assertEquals('Cal', $this->list->get(0)->offsetGet('name'));
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function canGetReversedOrderList()
    {
        $reversedList = $this->list->reverse();
        $this->assertEquals('Lionel', $reversedList->get(0)->offsetGet('name'));

        $newList = new GenericList(ArrayObject::class);
        $newReversedList = $newList->reverse(); // Here an InvalidOperationException is thrown!
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function canGetARandomValue()
    {
        $randElement = $this->list->rand();
        $this->assertArrayHasKey('name', $randElement);

        $newList = new GenericList(ArrayObject::class);
        $newList->rand(); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canCheckIfIndexExists()
    {
        $this->assertTrue($this->list->exists(0));
        $this->assertFalse($this->list->exists(20));
    }

    /** @test */
    public function canMergeNewDataIntoNewList()
    {
        $newList = $this->list->merge(
            [new ArrayObject(['name' => 'Max']), new ArrayObject(['name' => 'Alex'])]
        );
        $this->assertCount(11, $newList);
        $this->assertEquals('Max', $newList->get(9)->offsetGet('name'));
    }

    /** @test */
    public function canGetFirstElementOfList()
    {
        $arrayObject = $this->list->first();
        $this->assertEquals('John', $arrayObject->offsetGet('name'));
    }

    /** @test */
    public function canGetLastElementOfList()
    {
        $arrayObject = $this->list->last();
        $this->assertEquals('Lionel', $arrayObject->offsetGet('name'));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function canUpdateAnElement()
    {
        $isUpdated = $this->list->update(0, new ArrayObject(['name' => 'Elliot']));
        $this->assertTrue($isUpdated);
        $this->assertEquals('Elliot', $this->list->get(0)->offsetGet('name'));

        $this->list->update(0, 'Elliot'); // Here an InvalidArgumentException is thrown!
    }
}
