<?php

namespace Tests\Unit;

use ArrayObject;
use PHPCollections\Collections\Dictionary;
use PHPCollections\Collections\GenericList;
use PHPUnit\Framework\TestCase;
use StdClass;

class DictionaryTest extends TestCase
{
    /**
     * @var \PHPCollections\Collections\Dictionary
     */
    private $dictionary;

    public function setUp()
    {
        $this->dictionary = new Dictionary('string', 'string');
        $this->dictionary->add('name', 'Max');
        $this->dictionary->add('job', 'programmer');
        $this->dictionary->add('drink', 'no');
        $this->dictionary->add('smoke', 'no');
        $this->dictionary->add('dance', 'a little bit');
        $this->dictionary->add('drugs', 'no');
        $this->dictionary->add('age', '23');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function canAddValuesOfTheSpecifiedTypes()
    {
        $this->dictionary->add('nickname', 'maxalmonte14');
        $this->assertArrayHasKey('nickname', $this->dictionary->toArray());
        $this->dictionary->add('movies', new ArrayObject(['Plan 9', 'The creature of the black lagoon', 'Nigth of the living dead']));
    }

    /** @test */
    public function canCheckIfContainsAValue()
    {
        $this->assertTrue($this->dictionary->exists('drink'));
    }

    /** @test */
    public function canClearData()
    {
        $this->dictionary->clear();
        $this->assertEquals(0, $this->dictionary->count());
    }

    /** @test */
    public function canGetAnElementByIndex()
    {
        $job = $this->dictionary->get('job');
        $this->assertEquals('programmer', $job);

        $nullPointer = $this->dictionary->get('posts');

        $this->assertNull($nullPointer);
    }

    /** @test */
    public function canUpdateDataByMapping()
    {
        $newDictionary = $this->dictionary->map(function ($value) {
            return $value.'x';
        });

        $this->assertInstanceOf(Dictionary::class, $newDictionary);
        $this->assertEquals('nox', $newDictionary->get('smoke'));
    }

    /** @test */
    public function canConvertDictionaryToArray()
    {
        $array = $this->dictionary->toArray();

        $this->assertArrayHasKey('job', $array);
        $this->assertEquals('programmer', $array['job']);
    }

    /** @test */
    public function canRemoveDataByIndex()
    {
        $this->dictionary->add('post', 'Lorem ipsum dolor sit amet...');
        $this->dictionary->remove('post');
        $this->assertArrayNotHasKey('post', $this->dictionary->toArray());
    }

    /** @test */
    public function canFilterDataByKeyAndValue()
    {
        $dictionary = new Dictionary('string', 'array');
        $dictionary->add('books', ['Code smart', 'JS the good parts', 'Laravel up and running']);
        $dictionary->add('videogames', ['Assasin Creed', 'God of war', 'Need for speed']);

        $newDictionary = $dictionary->filter(function ($key, $value) {
            return $key === 'videogames';
        });

        $this->assertNotNull($newDictionary);
        $this->assertArrayHasKey('videogames', $newDictionary->toArray());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     * @expectedExceptionMessage You're trying to get data from an empty collection
     */
    public function canGetFirstElement()
    {
        $this->assertEquals('Max', $this->dictionary->first());

        $newDictionary = new Dictionary('string', 'int');

        $newDictionary->first(); // Here an InvalidOperationException is thrown!
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     * @expectedExceptionMessage You're trying to get data from an empty collection
     */
    public function canGetLastElement()
    {
        $this->assertEquals('23', $this->dictionary->last());
        $newDictionary = new Dictionary('string', 'int');

        $newDictionary->last(); // Here an InvalidOperationException is thrown!
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function canUpdateElementByIndex()
    {
        $isUpdated = $this->dictionary->update('job', 'PHP developer');

        $this->assertTrue($isUpdated);
        $this->assertEquals('PHP developer', $this->dictionary->get('job'));
        $this->dictionary->update('height', '2.80'); // Here an InvalidOperationException is thrown!
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function canMergeNewDataIntoNewDictionary()
    {
        $dictionary1 = new Dictionary('string', 'array');
        $dictionary1->add('english-spanish', ['one' => 'uno', 'two' => 'dos']);

        $translations = $dictionary1->merge(
            new Dictionary('string', 'array', ['english-japanese' => ['one' => 'ichi', 'two' => 'ni']])
        );

        $this->assertNotNull($translations);
        $this->assertCount(2, $translations);
        $this->assertArrayHasKey('english-spanish', $translations->toArray());
        $this->assertArrayHasKey('english-japanese', $translations->toArray());

        $dictionary2 = new Dictionary('string', 'string');
        $dictionary2->merge(
            new Dictionary('string', 'integer', ['one' => 1, 'two' => 2])
        ); // Here a InvalidOperationException is thrown!
    }

    /** @test */
    public function canGetKeyType()
    {
        $key = $this->dictionary->getKeyType();

        $this->assertInternalType('string', $key);
    }

    /** @test */
    public function canGetValueType()
    {
        $value = $this->dictionary->getValueType();

        $this->assertInternalType('string', $value);
    }

    /** @test */
    public function canSortByGivenRules()
    {
        $sortedDictionary = $this->dictionary->sort(function ($x, $y) {
            return strlen($x) <=> strlen($y);
        });

        $this->assertEquals('a little bit', $sortedDictionary->last());
    }

    /** @test */
    public function canIterateOverEachElement()
    {
        $this->dictionary->forEach(function (&$value, $key) {
            $value = $value.'x';
        });

        $this->assertEquals('Maxx', $this->dictionary->get('name'));
        $this->assertEquals('programmerx', $this->dictionary->get('job'));
    }

    /** @test */
    public function canCompareTwoDictionary()
    {
        $newDictionary = new Dictionary('string', 'string', [
            'drink' => 'no',
            'smoke' => 'no',
            'dance' => 'a little bit',
        ]);

        $diffDictionary = $this->dictionary->diff($newDictionary);

        $this->assertInstanceOf(Dictionary::class, $diffDictionary);
        $this->assertEquals($diffDictionary->get('job'), 'programmer');
        $this->assertCount(4, $diffDictionary);
    }

    /** @test */
    public function canNotCompareTwoDictionaryOfDifferentKeyTypes()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('The key type for this Dictionary is string, you cannot pass a Dictionary with integer as key type');

        $newDictionary = new Dictionary(
            'integer', 'string', [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five']
        );

        $diffDictionary = $this->dictionary->diff($newDictionary); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canNotCompareTwoDictionaryOfDifferentValueTypes()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('The value type for this Dictionary is string, you cannot pass a Dictionary with integer as value type');

        $newDictionary = new Dictionary(
            'string', 'integer', ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5]
        );

        $diffDictionary = $this->dictionary->diff($newDictionary); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function canSliceADictionary()
    {
        $this->assertCount(5, $this->dictionary->slice(2));
        $this->assertCount(5, $this->dictionary->slice(2, null));
        $this->assertCount(4, $this->dictionary->slice(2, 4));
        $this->assertNull((new Dictionary('string', 'string'))->slice(2));
    }

    /** @test */
    public function canCheckIfTheDictionaryContainsAGivenValue()
    {
        $this->assertTrue($this->dictionary->contains('Max'));
        $this->assertFalse($this->dictionary->contains('Almonte'));
    }

    /** @test */
    public function canCheckIfTwoDictionaryObjectsAreEqual()
    {
        $newDictionary = new Dictionary('string', 'string', [
            'name'  => 'Max',
            'job'   => 'programmer',
            'drink' => 'no',
            'smoke' => 'no',
            'dance' => 'a little bit',
            'drugs' => 'no',
            'age'   => '23',
        ]);

        $this->assertTrue($this->dictionary->equals($newDictionary));
        $this->assertFalse($this->dictionary->equals(new Dictionary('string', 'string')));
    }

    /** @test */
    public function canNotCheckIfAnDictionaryIsEqualToAnotherTypeOfCollection()
    {
        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You should only compare a Dictionary against another Dictionary');
        $this->dictionary->equals(new GenericList(StdClass::class));
    }

    /** @test */
    public function canSumANumericFieldOfTheDictionary()
    {
        $newList = new Dictionary(
            'string', 'integer',
            [
                'Kyle Lowry'   => 18,
                'Danny Green'  => 12,
                'Kawhi Leonard'=> 23,
                'Paskal Siakam'=> 16,
                'Serge Ibaka'  => 14,
            ]
        );
        $totalPoints = $newList->sum(function ($pair) {
            return $pair->getValue();
        });

        $this->assertEquals(83, $totalPoints);
    }

    /** @test */
    public function canNotSumANonNumericFieldOfTheDictionary()
    {
        $newList = new Dictionary(
            'string', 'integer',
            [
                'Kyle Lowry'   => 18,
                'Danny Green'  => 12,
                'Kawhi Leonard'=> 23,
                'Paskal Siakam'=> 16,
                'Serge Ibaka'  => 14,
            ]
        );

        $this->expectException('\PHPCollections\Exceptions\InvalidOperationException');
        $this->expectExceptionMessage('You cannot sum non-numeric values');
        $newList->sum(function ($pair) {
            return $pair->getKey();
        }); // Here an InvalidOperationException is thrown!
    }

    /** @test */
    public function itCanFillADictionaryWithData()
    {
        $this->dictionary->fill([
            'first_key'  => 'first_value',
            'second_key' => 'second_value',
        ]);

        $this->assertCount(9, $this->dictionary);
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('The key type specified for this dictionary is string, you cannot pass an integer');
        $this->dictionary->fill([0 => true]);
    }

    /** @test */
    public function it_can_use_extension_methods()
    {
        $this->dictionary::addExtensionMethod('toUpper', (function () {
            return $this->map(function ($row) {
                return $row = strtoupper($row);
            });
        })->bindTo($this->dictionary));

        $newDictionary = $this->dictionary::toUpper();

        $this->assertEquals($newDictionary->get('name'), 'MAX');
    }
}
