<?php

namespace Tests\Unit;

use PHPCollections\Collections\ArrayList;
use PHPCollections\Collections\GenericList;
use PHPUnit\Framework\TestCase;
use StdClass;

class ArrayListTest extends TestCase
{
    private $arrayList;

    public function setUp()
    {
        $this->arrayList = new ArrayList();
        $this->arrayList->add('Max');
        $this->arrayList->add(5);
        $this->arrayList->add(false);
        $this->arrayList->add(new StdClass());
        $this->arrayList->add(null);
    }

    /** @test */
    public function canAddElements()
    {
        $this->arrayList->add('last index');

        $lastIndex = $this->arrayList->count() - 1;

        $this->assertEquals('last index', $this->arrayList->get($lastIndex));
    }

    /** @test */
    public function canClearData()
    {
        $this->arrayList->clear();
        $this->assertEmpty($this->arrayList);
    }

    /** @test */
    public function canCheckIfIndexExists()
    {
        $this->assertTrue($this->arrayList->exists(0));
    }

    /** @test */
    public function canFilterByValue()
    {
        $newArrayList = $this->arrayList->filter(function ($value) {
            return is_string($value);
        });

        $this->assertNotNull($newArrayList);
        $this->assertCount(1, $newArrayList);
        $this->assertEquals('Max', $newArrayList->get(0));
    }

    /** @test */
    public function canCheckIfAValueIsContained()
    {
        $isContained = $this->arrayList->contains(null);

        $this->assertTrue($isContained);
    }

    /** @test */
    public function canGetFirstElement()
    {
        $firstElement = $this->arrayList->first();

        $this->assertEquals('Max', $firstElement);
    }

    /** @test */
    public function canGetLastElement()
    {
        $lastElement = $this->arrayList->last();

        $this->assertNull($lastElement);
    }

    /** @test */
    public function canUpdateTheElementsByMapping()
    {
        $newArrayList = $this->arrayList->map(function ($val) {
            if ($val == false) {
                return 'Empty value';
            } else {
                return $val;
            }
        });

        $this->assertContains('Empty value', $newArrayList->toArray());
    }

    /** @test */
    public function canMergeNewDataIntoNewArrayList()
    {
        $numbers = new ArrayList([1, 2, 3, 4, 5]);
        $newArrayList = $numbers->merge(new ArrayList([6, 7, 8, 9, 10]));

        $this->assertCount(10, $newArrayList);
        $this->assertEquals(1, $newArrayList->first());
        $this->assertEquals(10, $newArrayList->last());
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function cannotGetARandomValueFromEmptyArrayList()
    {
        $newArrayList = new ArrayList();
        $newArrayList->rand(); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canReverse()
    {
        $reversedList = $this->arrayList->reverse();
        $this->assertEquals(null, $reversedList->first());
        $this->assertEquals('Max', $reversedList->last());
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function cannotReverseAnEmptyArrayList()
    {
        $newArrayList = new ArrayList();
        $reversedList = $newArrayList->reverse(); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canUpdateAValue()
    {
        $this->arrayList->update(0, 'John');
        $this->assertEquals('John', $this->arrayList->get(0));
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function cannotUpdateAnNonExistingValue()
    {
        $newArrayList = new ArrayList();
        $newArrayList->update(0, 'Some value'); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canIterateOverEachElement()
    {
        $this->arrayList->forEach(function (&$value, $key) {
            if (!is_object($value) && $value) {
                $value = $value.'x';
            }
        });

        $this->assertEquals('Maxx', $this->arrayList->get(0));
        $this->assertEquals('5x', $this->arrayList->get(1));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function canRemoveElementByIndex()
    {
        $this->assertEquals('Max', $this->arrayList->get(0));
        $this->arrayList->remove(0);

        $this->assertFalse($this->arrayList->contains('Max'));
        $this->arrayList->remove(0); // Here an OutOfRangeException is thrown!
    }

    /** @test */
    public function canCompareTwoArrayList()
    {
        $newList = new ArrayList(['Max', 5, false]);
        $diffList = $this->arrayList->diff($newList);

        $this->assertInstanceOf(ArrayList::class, $diffList);
        $this->assertTrue($diffList->contains(null));
        $this->assertCount(2, $diffList);
    }

    /** @test */
    public function canNotCompareAnArrayListAgainstAnotherTypeOfCollection()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You should only compare an ArrayList against another ArrayList');

        $newList = new GenericList(
            StdClass::class,
            new StdClass(['name' => 'John']),
            new StdClass(['name' => 'Carter'])
        );

        $diffList = $this->arrayList->diff($newList); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canSliceAnArrayList()
    {
        $this->assertCount(3, $this->arrayList->slice(2));
        $this->assertCount(3, $this->arrayList->slice(2, null));
        $this->assertCount(3, $this->arrayList->slice(2, 3));
        $this->assertNull((new ArrayList())->slice(2));
    }

    /** @test */
    public function canCheckIfTwoArrayListAreEqual()
    {
        $newArrayList = new ArrayList(['Max', 5, false, new StdClass(), null]);

        $this->assertTrue($this->arrayList->equals($newArrayList));
        $this->assertFalse($this->arrayList->equals(new ArrayList(['Max', 5, false])));
    }

    /** @test */
    public function canNotCheckIfAnArrayListIsEqualToAnotherTypeOfCollection()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You should only compare an ArrayList against another ArrayList');
        $this->arrayList->equals(new GenericList(StdClass::class));
    }

    /** @test */
    public function canSumANumericFieldOfTheArrayList()
    {
        $newList = new ArrayList([18, 12, 23, 16, 14]);
        $totalPoints = $newList->sum(function ($points) {
            return $points;
        });

        $this->assertEquals(83, $totalPoints);
    }

    /** @test */
    public function canNotSumANonNumericFieldOfTheArrayList()
    {
        $newList = new ArrayList(['Kyle Lowry', 'Danny Green', 'Kawhi Leonard', 'Paskal Siakam', 'Serge Ibaka']);

        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You cannot sum non-numeric values');
        $newList->sum(function ($name) {
            return $name;
        }); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function itCanFillAnArrayListWithData()
    {
        $this->arrayList->fill([
            'first_value',
            'second_value',
        ]);

        $this->assertCount(7, $this->arrayList);
    }

    /** @test */
    public function it_can_use_extension_methods()
    {
        $this->arrayList::addExtensionMethod('onlyStrings', (function () {
            return $this->filter(function ($row) {
               return is_string($row);
            });
        })->bindTo($this->arrayList));

        $newList = $this->arrayList::onlyStrings();

        $this->assertEquals(1, $newList->count());
    }
}
