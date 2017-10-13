<?php

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
     * @expectedException InvalidArgumentException
     */
    public function testAddValuesToDictionary()
    {
        $this->dictionary->add('movies', new ArrayObject(['Plan 9', 'The creature of the black lagoon', 'Nigth of the living dead']));
        $this->assertArrayHasKey('movies', $this->dictionary);
        $this->dictionary->add(5, new ArrayObject([1, 2, 3, 4, 5]));
    }

    public function testDictionaryContainsValue()
    {
        $this->assertTrue($this->dictionary->exists('drink'));
    }

    public function testClearDictionary()
    {
        $this->dictionary->clear();
        $this->assertCount(0, $this->dictionary);
        $this->setUp();
    }

    public function testFindInDictionary()
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

    public function testGetOfDictionary()
    {
        $job = $this->dictionary->get('job');
        $this->assertEquals('programmer', $job);

        $nullPointer = $this->dictionary->get('posts');
        $this->assertNull($nullPointer);
    }

    public function testMapDictionary()
    {
        $newDictionary = $this->dictionary->map(function ($value) {
            return $value == 'no';
        });

        $this->assertInstanceOf(Dictionary::class, $newDictionary);
        $this->assertArrayHasKey('smoke', $newDictionary);
        $this->assertEquals('no', $newDictionary->get('smoke'));
    }

    public function testToArrayDictionary()
    {
        $array = $this->dictionary->toArray();
        $this->assertArrayHasKey('job', $array);
        $this->assertEquals('programmer', $array['job']);
    }

    public function testRemoveFromDictionary()
    {
        $this->dictionary->add('post', 'Lorem ipsum dolor sit amet...');
        $this->dictionary->remove('post');
        $this->assertArrayNotHasKey('post', $this->dictionary->toArray());
    }

    public function testFilterDictionary()
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
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function testGetFirstElementFromDictionary()
    {
        $this->assertEquals('Max', $this->dictionary->first());
        $newDictionary = new Dictionary('string', 'int');
        $newDictionary->first(); // Here an InvalidOperationException is thrown!
    }

    /**
     * @expectedException PHPCollections\Exceptions\InvalidOperationException
     */
    public function testGetLastElementFromDictionary()
    {
        $this->assertEquals('23', $this->dictionary->last());
        $newDictionary = new Dictionary('string', 'int');
        $newDictionary->last(); // Here an InvalidOperationException is thrown!
    }
}