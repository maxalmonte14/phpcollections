PHPCollections\Collections\ArrayList
===============

A list of values of any type.

* Class name: ArrayList
* Namespace: PHPCollections\Collections
* This class implements: CollectionInterface, IterableInterface, MergeableInterface, SortableInterface

Methods
-------

### add

    void PHPCollections\Collections\ArrayList::add(mixed $value)

Adds a new element to the collection.

* Visibility: **public**

#### Arguments
* $value **mixed**

### contains

    boolean PHPCollections\Collections\ArrayList::contains(mixed $needle)

 Checks if the collection
 contains a given value.

* Visibility: **public**

#### Arguments
* $needle **mixed**

### diff

    ArrayList PHPCollections\Collections\ArrayList::diff(ArrayList $newArrayList)

 Gets the difference between two ArrayList.

* Visibility: **public**

#### Arguments
* $newArrayList **\PHPCollections\Collections\ArrayList**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### filter

    ?ArrayList PHPCollections\Collections\ArrayList::filter(callable $callback)

Returns all the coincidences found
for the given callback or null.

* Visibility: **public**

#### Arguments
* $callback **callable**

### find

    ?ArrayList PHPCollections\Collections\ArrayList::find(callable $callback, boolean $shouldStop = false)

 Searches for one or more elements
 in the collection.

* Visibility: **public**

#### Arguments
* $callback **callable**
* $shouldStop **boolean**

### forEach

    void PHPCollections\Collections\ArrayList::forEach(callable $callback)

Iterates over every element of the collection.

* Visibility: **public**

#### Arguments
* $callback **callable**

### get

    mixed PHPCollections\Collections\ArrayList::get(integer $offset)

Gets the element specified
at the given index.

* Visibility: **public**

#### Arguments
* $offset **integer**

### map

    ?ArrayList PHPCollections\Collections\ArrayList::map(callable $callback)

Updates elements in the collection by
applying a given callback function.

* Visibility: **public**

#### Arguments
* $callback **callable**

### merge

    ArrayList PHPCollections\Collections\ArrayList::merge(ArrayList $newArrayList)

Merges two ArrayList into a new one.

* Visibility: **public**

#### Arguments
* $newArrayList **\PHPCollections\Collections\ArrayList**

### rand

    mixed PHPCollections\Collections\ArrayList::rand()

Returns a random element of
the collection.

* Visibility: **public**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### remove

    void PHPCollections\Collections\ArrayList::remove(integer $offset)

Removes an item from the collection
and repopulates the data array.

* Visibility: **public**

#### Arguments
* $offset **integer**

#### Throws
* **\OutOfRangeException**

### reverse

    ArrayList PHPCollections\Collections\ArrayList::reverse()

Returns a new collection with the
reversed values.

* Visibility: **public**

#### Throws
* **\PHPCollections\Exceptions\InvalidOperationException**

### sort

    ?ArrayList PHPCollections\Collections\ArrayList::sort(callable $callback)

Returns a new ArrayList with the values ordered by a given callback if couldn't sort returns null.

* Visibility: **public**

#### Arguments
* $callback **callable**

### update

    bool PHPCollections\Collections\ArrayList::update(integer $index, mixed $value)

 Updates the value of the element
 at the given index.

* Visibility: **public**

#### Arguments
* $index **integer**
* $value **mixed**
