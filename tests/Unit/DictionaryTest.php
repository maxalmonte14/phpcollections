<?php

namespace Tests\Unit;

use \ArrayObject;
use PHPUnit\Framework\TestCase;
use PHPCollections\Collections\Dictionary;

class DictionaryTest extends TestCase
{

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
        $this->assertCount(0, $this->dictionary);
    }

    /** @test */
    public function canFindOneOrMoreElementsByValue()
    {
        $name = $this->dictionary->find(function ($value) {
            return $value === 'Max';
        });

        $this->assertEquals('Max', $name);
        $this->assertNotEquals('Lionel', $name);

        $nullPointer = $this->dictionary->find(function ($value) {
            return $value === 'Lionel';
        });
        $this->assertNull($nullPointer);
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
            return $value = 'no';
        });

        $this->assertInstanceOf(Dictionary::class, $newDictionary);
        $this->assertArrayHasKey('smoke', $newDictionary);
        $this->assertEquals('no', $newDictionary->get('smoke'));
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
        $removed = $this->dictionary->remove('post');
        
        $this->assertTrue($removed);
        $this->assertArrayNotHasKey('post', $this->dictionary->toArray());
    }

    /** @test */
    public function canFilterDataByKeyAndValue()
    {
        $dictionary = new Dictionary('string', 'array');
        $dictionary->add('books', ['Code smart', 'JS the good parts', 'Laravel up and running']);
        $dictionary->add('videogames', ['Assasin Creed', 'God of war', 'Need for speed']);
        
        $newDictionary = $dictionary->filter(function ($k, $v) {
            return $k === 'videogames';
        });

        $this->assertNotNull($newDictionary);
        $this->assertArrayHasKey('videogames', $newDictionary->toArray());
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function canGetFirstElement()
    {
        $this->assertEquals('Max', $this->dictionary->first());

        $newDictionary = new Dictionary('string', 'int');
        
        $newDictionary->first(); // Here an InvalidOperationException is thrown!
    }

    /**
     * @test
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
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
            new Dictionary('string', 'array', ['english-japanese' => array('one' => 'ichi', 'two' => 'ni')])
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
        $sorted = $this->dictionary->sort(function ($x, $y) {
            return strlen($x->getValue()) <=> strlen($y->getValue());
        });
        
        $this->assertTrue($sorted);
        $this->assertEquals('a little bit', $this->dictionary->last());
    }

    /** @test */
    public function canIterateOverEachElement()
    {
        $this->dictionary->forEach(function ($pair, $key) {
            $pair->setValue($pair->getValue($key) . 'x');
        });

        $this->assertEquals('Maxx', $this->dictionary->get('name'));
        $this->assertEquals('programmerx', $this->dictionary->get('job'));
    }
}
