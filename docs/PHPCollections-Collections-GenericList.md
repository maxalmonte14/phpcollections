PHPCollections\Collections\GenericList
===============

A list for a generic type of data.

* Class name: GenericList
* Namespace: PHPCollections\Collections
* This class extends: BaseCollection
* This class implements: CollectionInterface, IterableInterface, SortableInterface

Properties
----------

### $type

    private mixed $type

The type of data that
will be stored.

* Visibility: **private**

Methods
-------

### __construct

    void PHPCollections\Collections\GenericList::__construct(string $type, array $data)

Initializes the class properties.

* Visibility: **public**

#### Arguments
* $type **string**
* $data **array**

### add

    void PHPCollections\Collections\GenericList::add(mixed $value)

Adds a new object to the collection.

* Visibility: **public**

#### Arguments
* $value **mixed**

### checkType

    void PHPCollections\Collections\GenericList::checkType(mixed $data)

Determines if the passed data is
of the type specified in the type
attribute, if not throws and Exception.

* Visibility: **private**

#### Arguments
* $values **mixed**

#### Throws
* **\InvalidArgumentException**

### filter

    ?GenericList PHPCollections\Collections\GenericList::filter(callable $callback)

Returns all the coincidences found
for the given callback or null.

* Visibility: **public**

#### Arguments
* $callback **callable**

### find

    ?mixed PHPCollections\Collections\GenericList::find(callable $callback)

Returns the first element that
matches whith the callback criteria.

* Visibility: **public**

#### Arguments
* $callback **callable**

### first

    mixed PHPCollections\Collections\GenericList::first()

Gets the first element of the collection.

* Visibility: **public**

#### Throws
**\OutOfRangeException**

### forEach

    void PHPCollections\Collections\GenericList::forEach(callable $callback)

Iterates over every element of the collection.

* Visibility: **public**

#### Arguments
* $callback **callable**

### get

    ?object PHPCollections\Collections\GenericList::get(int $offset)

Returns the object at the specified index
or null if it's not defined.

* Visibility: **public**

#### Arguments
* $offset **int**

#### Throws
* **\OutOfRangeException**

### last

    mixed PHPCollections\Collections\GenericList::last()

Gets the last element of the collection.

* Visibility: **public**

#### Throws
* **\OutOfRangeException**

### map

    ?GenericList PHPCollections\Collections\GenericList::map(callable $callback)

Updates elements in the collection by
applying a given callback function.

* Visibility: **public**

#### Arguments
* $callback **callable**

### merge

    GenericList PHPCollections\Collections\GenericList::merge(array $data)

Merges new data with the actual
collection and returns a new one.

* Visibility: **public**

#### Arguments
* $data **array**

### rand

    mixed PHPCollections\Collections\GenericList::rand()

Returns a random element from
the collection.

* Visibility: **public**

### remove

    bool PHPCollections\Collections\GenericList::remove(int $offset)

Removes an item from the collection
and repopulate the data container.

* Visibility: **public**

#### Arguments
* $offset **int**

#### Throws
* **\OutOfRangeException**

### repopulate

    void PHPCollections\Collections\GenericList::repopulate()

Repopulates the data container.

* Visibility: **private**

### reverse

    GenericList PHPCollections\Collections\GenericList::reverse()

Returns a new collection with the
reversed values.

* Visibility: **public**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### search

    ?GenericList PHPCollections\Collections\GenericList::search(callable $callback, boolean $shouldStop = false)

Searches one or more elements in
the collection.

* Visibility: **public**

#### Arguments
* $callback **callable**
* $shouldStop **boolean**

### sort

    bool PHPCollections\Collections\GenericList::sort(callable $callback)

Sorts the collection data by values
applying a given callback.

* Visibility: **public**

#### Arguments
* $callback **callable**

### update

    bool PHPCollections\Collections\GenericList::update(integer $index, mixed $value)

Updates the value of the element
at the given index.

* Visibility: **public**

#### Arguments
* $index **integer**
* $value **mixed**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**
