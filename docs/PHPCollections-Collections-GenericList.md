PHPCollections\Collections\GenericList
===============

A list for a generic type of data.

* Class name: GenericList
* Namespace: PHPCollections\Collections
* This class extends: BaseCollection
* This class implements: ObjectCollectionInterface, IterableInterface, MergeableInterface,SortableInterface

Properties
----------

### $error

    private string $error

The error message to show when someone try to store a value of a different type than the specified in the type property.

* Visibility: **private**

### $type

    private string $type

The type of data that
will be stored.

* Visibility: **private**

Methods
-------

### __construct

    void PHPCollections\Collections\GenericList::__construct(string $type, object ...$data)

Creates a new GenericList.

* Visibility: **public**

#### Arguments
* $type **string**
* $data **object ...**

#### Throws
* **\InvalidArgumentException**

### add

    void PHPCollections\Collections\GenericList::add(mixed $value)

Adds a new object to the collection.

* Visibility: **public**

#### Arguments
* $value **mixed**

#### Throws
* **\InvalidArgumentException**

### diff

    GenericList PHPCollections\Collections\GenericList::diff(GenericList $newGenericList)

 Gets the difference between two GenericList.

* Visibility: **public**

#### Arguments
* $newGenericList **\PHPCollections\Collections\GenericList**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

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

### map

    ?GenericList PHPCollections\Collections\GenericList::map(callable $callback)

Updates elements in the collection by
applying a given callback function.

* Visibility: **public**

#### Arguments
* $callback **callable**

### merge

    GenericList PHPCollections\Collections\GenericList::merge(GenericList $newGenericList)

Merges two GenericList into a new one.

* Visibility: **public**

#### Arguments
* $data **\PHPCollections\Collections\GenericList**

#### Throws
* **\InvalidArgumentException**

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

### slice

    ?GenericList PHPCollections\Collections\GenericList::slice(int $offset, ?int $length = null)

 Returns a portion of the GenericList.

* Visibility: **public**

#### Arguments
* $offset **int**
* $length **int**

### sort

    ?GenericList PHPCollections\Collections\GenericList::sort(callable $callback)

Returns a new GenericList with the values ordered by a given callback if couldn't sort returns null.

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
* **\InvalidArgumentException**
