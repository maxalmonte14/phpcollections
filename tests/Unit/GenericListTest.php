<?php

namespace Tests\Unit;

use ArrayObject;
use PHPCollections\Collections\ArrayList;
use PHPCollections\Collections\GenericList;
use PHPUnit\Framework\TestCase;
use StdClass;

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

    /** @test */
    public function canCreateACollectionWithMultipleParameters()
    {
        $this->list = null;
        $this->list = new GenericList(
            ArrayObject::class,
            new ArrayObject(['name' => 'John']),
            new ArrayObject(['name' => 'Finch']),
            new ArrayObject(['name' => 'Shaw']),
            new ArrayObject(['name' => 'Carter'])
        );

        $this->assertInstanceOf(GenericList::class, $this->list);
        $this->assertCount(4, $this->list);
    }

    /**
     * @test
     */
    public function canAddAnElementToList()
    {
        $this->assertCount(9, $this->list);
        $this->list->add(new ArrayObject(['name' => 'Samaritan']));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The type specified for this collection is
     * ArrayObject, you cannot pass an object of type stdClass
     */
    public function canNotAddAnElementOfDifferentTypeToList()
    {
        $this->list->add(new StdClass()); // Here an InvalidArgumentException is thrown!
    }

    /** @test */
    public function canClearData()
    {
        $this->list->clear();
        $this->assertCount(0, $this->list);
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
        $newList = $this->list->sort(function ($a, $b) {
            return $a->offsetGet('name') <=> $b->offsetGet('name');
        });

        $this->assertEquals('Cal', $newList->get(0)->offsetGet('name'));
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
            new GenericList(
                ArrayObject::class,
                new ArrayObject(['name' => 'Max']),
                new ArrayObject(['name' => 'Alex'])
            )
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
     */
    public function canUpdateAnElement()
    {
        $isUpdated = $this->list->update(0, new ArrayObject(['name' => 'Elliot']));
        $this->assertTrue($isUpdated);
        $this->assertEquals('Elliot', $this->list->get(0)->offsetGet('name'));
    }

    /** @test */
    public function canIterateOverEachElement()
    {
        $this->list->forEach(function ($value, $key) {
            $value->offsetSet('name', $value->offsetGet('name').'x');
        });

        $this->assertEquals('Johnx', $this->list->get(0)->offsetGet('name'));
    }

    /** @test */
    public function canCompareTwoGenericListOfTheSameType()
    {
        $newList = new GenericList(
            ArrayObject::class,
            new ArrayObject(['name' => 'John']),
            new ArrayObject(['name' => 'Finch']),
            new ArrayObject(['name' => 'Shaw']),
            new ArrayObject(['name' => 'Carter'])
        );

        $diffList = $this->list->diff($newList);

        $this->assertInstanceOf(GenericList::class, $diffList);
        $this->assertEquals('Kara', $diffList->first()['name']);
        $this->assertEquals('Lionel', $diffList->last()['name']);
        $this->assertCount(5, $diffList);
    }

    /** @test */
    public function canNotCompareTwoGenericListOfDifferentTypes()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('This is a collection of ArrayObject objects, you cannot pass a collection of StdClass objects');

        $newList = new GenericList(
            StdClass::class,
            new StdClass(['name' => 'John']),
            new StdClass(['name' => 'Finch']),
            new StdClass(['name' => 'Shaw']),
            new StdClass(['name' => 'Carter'])
        );

        $diffList = $this->list->diff($newList); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canNotCompareAGenericListAgainstAnotherTypeOfCollection()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You should only compare a GenericList against another GenericList');

        $newList = new ArrayList([
            new StdClass(['name' => 'John']),
            new StdClass(['name' => 'Finch']),
            new StdClass(['name' => 'Shaw']),
            new StdClass(['name' => 'Carter']),
        ]);

        $diffList = $this->list->diff($newList); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canSliceAGenericList()
    {
        $this->assertCount(7, $this->list->slice(2));
        $this->assertCount(7, $this->list->slice(2, null));
        $this->assertCount(5, $this->list->slice(2, 5));
        $this->assertNull((new GenericList(\StdClass::class))->slice(2));
    }

    /** @test */
    public function canCheckIfTheGenericListContainsAGivenValue()
    {
        $this->assertTrue($this->list->contains(new ArrayObject(['name' => 'John'])));
        $this->assertFalse($this->list->contains(new ArrayObject(['name' => 'Max'])));
    }

    /** @test */
    public function canCheckIfTwoGenericListAreEqual()
    {
        $newList = new GenericList(
            ArrayObject::class,
            new ArrayObject(['name' => 'John']),
            new ArrayObject(['name' => 'Finch']),
            new ArrayObject(['name' => 'Shaw']),
            new ArrayObject(['name' => 'Carter']),
            new ArrayObject(['name' => 'Kara']),
            new ArrayObject(['name' => 'Snow']),
            new ArrayObject(['name' => 'Zoey']),
            new ArrayObject(['name' => 'Cal']),
            new ArrayObject(['name' => 'Lionel'])
        );

        $this->assertTrue($this->list->equals($newList));
        $this->assertFalse(
            $this->list->equals(new GenericList(ArrayObject::class, new ArrayObject(['name' => 'Max'])))
        );
    }

    /** @test */
    public function canNotCheckIfAGenericListIsEqualToAnotherTypeOfCollection()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You should only compare an GenericList against another GenericList');
        $this->list->equals(new ArrayList(['first', 'second', 'third'])); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canSumANumericFieldOfTheGenericList()
    {
        $newList = new GenericList(
            ArrayObject::class,
            new ArrayObject(['name' => 'Kyle Lowry', 'points' => 18]),
            new ArrayObject(['name' => 'Danny Green', 'points' => 12]),
            new ArrayObject(['name' => 'Kawhi Leonard', 'points' => 23]),
            new ArrayObject(['name' => 'Paskal Siakam', 'points' => 16]),
            new ArrayObject(['name' => 'Serge Ibaka', 'points' => 14])
        );
        $totalPoints = $newList->sum(function ($arrayObject) {
            return $arrayObject->offsetGet('points');
        });

        $this->assertEquals(83, $totalPoints);
    }

    /** @test */
    public function canNotSumANonNumericFieldOfTheGenericList()
    {
        $newList = new GenericList(
            ArrayObject::class,
            new ArrayObject(['name' => 'Kyle Lowry', 'points' => 18]),
            new ArrayObject(['name' => 'Danny Green', 'points' => 12]),
            new ArrayObject(['name' => 'Kawhi Leonard', 'points' => 23]),
            new ArrayObject(['name' => 'Paskal Siakam', 'points' => 16]),
            new ArrayObject(['name' => 'Serge Ibaka', 'points' => 14])
        );

        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You cannot sum non-numeric values');
        $newList->sum(function ($arrayObject) {
            return $arrayObject->offsetGet('name');
        }); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function itCanFillAGenericListWithData()
    {
        $this->list->fill([
            new ArrayObject(['name' => 'Max']),
            new ArrayObject(['name' => 'John']),
        ]);

        $this->assertCount(11, $this->list);
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('The type specified for this collection is ArrayObject, you cannot pass an object of type stdClass');
        $this->list->fill([new StdClass()]);
    }
}
