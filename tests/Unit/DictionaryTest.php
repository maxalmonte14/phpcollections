<?php

use PHPUnit\Framework\TestCase;
use PHPCollections\Collections\Dictionary;

class DictionaryTest extends TestCase
{

    private $dictionary;

    public function setUp()
    {
        $this->dictionary = new Dictionary('string', ArrayObject::class);
        $this->dictionary->add('user', new ArrayObject(['name' => 'Max', 'age' => 23, 'job' => 'programmer', 'married' => false]));
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
        $this->assertTrue($this->dictionary->exists('user'));
    }

    public function testClearDictionary()
    {
        $this->dictionary->clear();
        $this->assertCount(0, $this->dictionary);
        $this->setUp();
    }

    public function testFindInDictionary()
    {
        $arrayObject = $this->dictionary->find(function ($value) {
            return $value['name'] === 'Max';
        });

        $this->assertEquals('Max', $arrayObject->offsetGet('name'));
        $this->assertNotEquals('Lionel', $arrayObject->offsetGet('name'));

        $nullPointer = $this->dictionary->find(function ($value) {
            return $value['name'] === 'Lionel';
        });
        $this->assertNull($nullPointer);
    }

    public function testGetOfDictionary()
    {
        $arrayObject = $this->dictionary->get('user');
        $this->assertArrayHasKey('name', $arrayObject);

        $nullPointer = $this->dictionary->get('posts');
        $this->assertNull($nullPointer);
    }

    public function testMapDictionary()
    {
        $newDictionary = $this->dictionary->map(function ($value) {
            return $value['age'] = $value['age'] * 2;
            return $value;
        });

        $this->assertInstanceOf(Dictionary::class, $newDictionary);
        $this->assertArrayHasKey('user', $newDictionary);
        $this->assertEquals(46, $newDictionary->get('user')->offsetGet('age'));
    }

    public function testToArrayDictionary()
    {
        $array = $this->dictionary->toArray();
        $this->assertArrayHasKey('user', $array);
        $this->assertInstanceOf(ArrayObject::class, $array['user']);
    }

    public function testRemoveFromDictionary()
    {
        $this->dictionary->add('posts', new ArrayObject([
            ['title' => 'First post', 'content' => 'Blah, blah, blah'],
            ['title' => 'Second post', 'content' => 'Blah, blah, blah'],
        ]));
        $this->dictionary->remove('posts');
        $this->assertArrayNotHasKey('posts', $this->dictionary->toArray());
    }
}