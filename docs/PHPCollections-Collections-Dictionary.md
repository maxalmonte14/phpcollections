PHPCollections\Collections\Dictionary
===============

A Pair object collection
represented by a generic
type key and value.

* Class name: Dictionary
* Namespace: PHPCollections\Collections
* This class extends: AbstractCollection
* This class implements: DictionaryInterface, MergeableInterface, SortableInterface

Properties
----------

### $keyType

    private mixed $keyType

The type of the keys
for this dictionary.

* Visibility: **private**

### $valueType

    private mixed $valueType

The type of the values
for this dictionary.

* Visibility: **private**

Methods
-------

### __construct

    void PHPCollections\Collections\Dictionary::__construct(mixed $keyType, mixed $valueType, array $data = [])

Creates a new Dictionary.

* Visibility: **public**

#### Arguments
* $keyType **mixed**
* $valueType **mixed**
* $data **array**

#### Throws
* **\InvalidArgumentException**

### add

    void PHPCollections\Collections\Dictionary::add(mixed $key, mixed $value)

Adds a new value to the dictionary.

* Visibility: **public**

#### Arguments
* $key **mixed**
* $value **mixed**

#### Throws
* **\InvalidArgumentException**

### diff

    Dictionary PHPCollections\Collections\Dictionary::diff(Dictionary $newDictionary)

 Gets the difference between two Dictionary.

* Visibility: **public**

#### Arguments
* $newDictionary **\PHPCollections\Collections\Dictionary**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### equals

    boolean PHPCollections\Collections\Dictionary::equals(Dictionary $collection)

Determines if two Dictionary objects are equal.

* Visibility: **public**

#### Arguments
* $collection **\PHPCollections\Collections\Dictionary**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### filter

    ?Dictionary PHPCollections\Collections\Dictionary::filter(callable $callback)

Filters the collection applying
a given callback.

* Visibility: **public**

#### Arguments
* $callback **callable**

### forEach

    void PHPCollections\Collections\Dictionary::forEach(callable $callback)

Iterates over every element of the collection.

* Visibility: **public**

#### Arguments
* $callback **callable**

### get

    ?mixed PHPCollections\Collections\Dictionary::get(mixed $key)

Returns the value for the specified
key or null if it's not defined.

* Visibility: **public**

#### Arguments
* $key **mixed**

### getKeyType

    mixed PHPCollections\Collections\Dictionary::getKeyType()

Returns the key type for this collection.

* Visibility: **public**

### getValueType

    mixed PHPCollections\Collections\Dictionary::getValueType()

Returns the key value for this collection.

* Visibility: **public**

### initializePairs

    void PHPCollections\Collections\Dictionary::initializePairs(array $data)

Populates the container with Pair objects.

* Visibility: **private**

#### Arguments
* $data **array**

### map

    ?Dictionary PHPCollections\Collections\Dictionary::map(callable $callback)

Updates elements in the collection by
applying a given callback function.

* Visibility: **public**

#### Arguments
* $callback **callable**

### merge

    Dictionary PHPCollections\Collections\Dictionary::merge(Dictionary $newDictionary)

Merges two dictionaries into a new one.

* Visibility: **public**

#### Arguments
* $newDictionary **PHPCollections\Collections\Dictionary**

#### Throws
* **\InvalidArgumentException**

### remove

    boolean PHPCollections\Collections\Dictionary::remove(mixed key)

Removes a value from the dictionary.

* Visibility: **public**

#### Arguments
* $key **mixed**

### slice

    ?Dictionary PHPCollections\Collections\Dictionary::slice(int $offset, ?int $length = null)

 Returns a portion of the Dictionary.

* Visibility: **public**

#### Arguments
* $offset **int**
* $length **int**

### sort

    ?Dictionary PHPCollections\Collections\Dictionary::sort(callable $callback)

Returns a new Dictionary with the values ordered by a given callback if couldn't sort returns null.

* Visibility: **public**

#### Arguments
* $callback **callable**

### toArray

    array PHPCollections\Collections\Dictionary::toArray()

Returns an array representation
of your dictionary data.

* Visibility: **public**

### toJson

    string PHPCollections\Collections\Dictionary::toJson()

Returns a JSON representation
of your dictionary data.

* Visibility: **public**

#### Arguments
* $key **mixed**
* $value **mixed**

### update

    boolean PHPCollections\Collections\Dictionary::update(mixed $key, mixed $value)

Updates the value of one Pair
in the collection.

* Visibility: **public**

#### Arguments
* $key **mixed**
* $value **mixed**

#### Throws
* **\InvalidArgumentException**
* **\PHPCollections\Exceptions\InvalidOperationException**

### validateEntry

    boolean PHPCollections\Collections\Dictionary::validateEntry(mixed $key, mixed $value)

Validates that a key and value are of the specified types in the class.

* Visibility: **private**

#### Arguments
* $key **mixed**
* $value **mixed**

#### Throws
* **\InvalidArgumentException**