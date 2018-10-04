PHPCollections\Collections\Dictionary
===============

A Pair object collection
represented by a generic
type key and value.

* Class name: Dictionary
* Namespace: PHPCollections\Collections
* This class extends: BaseCollection
* This class implements: DictionaryInterface

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

Initializes the class properties.

* Visibility: **public**

#### Arguments
* $keyType **mixed**
* $valueType **mixed**
* $data **array**

### add

    void PHPCollections\Collections\Dictionary::add(mixed $key, mixed $value)

Adds a new value to the dictionary.

* Visibility: **public**

#### Arguments
* $key **mixed**
* $value **mixed**

### checkType

    void PHPCollections\Collections\Dictionary::checkType(mixed $values)

Determines if the passed data is
of the type specified in the keyType/valueType
attribute, if not throws and InvalidArgumentException.

* Visibility: **private**

#### Arguments
* $values **mixed**

#### Throws
* **\InvalidArgumentException**

### filter

    ?Dictionary PHPCollections\Collections\Dictionary::filter(callable $callback)

Filters the collection applying
a given callback.

* Visibility: **public**

#### Arguments
* $callback **callable**

### find

    ?mixed PHPCollections\Collections\Dictionary::find(callable $callback)

Finds an element based on a given callback.

* Visibility: **public**

#### Arguments
* $callback **callable**

### first

    mixed PHPCollections\Collections\Dictionary::first()

Returns the first element in the collection.

* Visibility: **public**

#### Throws
**\PHPCollections\Exceptions\InvalidOperationException**

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

### last

    mixed PHPCollections\Collections\Dictionary::last()

Returns the last element of
the collection.

* Visibility: **public**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

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

### remove

    bool PHPCollections\Collections\Dictionary::remove(mixed key)

Removes a value from the dictionary.

* Visibility: **public**

#### Arguments
* $key **mixed**

### sort

    ?Dictionary PHPCollections\Collections\Dictionary::sort(callable $callback)

Sorts the collection data by values
applying a given callback.

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

    bool PHPCollections\Collections\Dictionary::update(mixed $key, mixed $value)

Updates the value of one Pair
in the collection.

* Visibility: **public**

#### Arguments
* $key **mixed**
* $value **mixed**
