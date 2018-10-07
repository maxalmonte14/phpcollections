<?php

namespace Tests\Unit;

use StdClass;
use PHPUnit\Framework\TestCase;
use PHPCollections\Collections\ArrayList;

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
                return "Empty value";
            } else {
                return $val;
            }
        });

        $this->assertContains("Empty value", $newArrayList->toArray());
    }

    /** @test */
    public function canFindMatchingElements()
    {
        $elements = $this->arrayList->find(function ($v, $k) {
            return $v != false;
        });

        $this->assertCount(3, $elements);
        $this->assertFalse($elements->contains(false));
        $this->assertFalse($elements->contains(null));

        $singleElement = $this->arrayList->find(function ($v, $k) {
            return !is_string($v);
        }, true);

        $this->assertCount(1, $singleElement);
        $this->assertEquals(5, $singleElement->get(0));
    }

    /** @test */
    public function canMergeNewDataIntoNewArrayList()
    {
        $numbers = new ArrayList([1,2,3,4,5]);
        $newArrayList = $numbers->merge(new ArrayList([6,7,8,9,10]));
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
}
