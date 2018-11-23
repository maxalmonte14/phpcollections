PHPCollections\Collections\AbstractCollection
===============

The base class for countable and
JSON serializable collections.

* Class name: AbstractCollection
* Namespace: PHPCollections\Collections
* This is an **abstract** class
* This class implements: Countable, JsonSerializable

Properties
----------

### $store

    protected \PHPCollections\Store $store

The data container.

* Visibility: **protected**

Methods
-------

### __construct

    void PHPCollections\Collections\AbstractCollection::__construct(array $data)

Initializes the store property.

* Visibility: **public**

#### Arguments
* $data **array**

### clear

    void PHPCollections\Collections\AbstractCollection::clear()

Reinitializes the store property.

* Visibility: **public**

### contains

    boolean PHPCollections\Collections\ArrayList::contains(mixed $needle)

 Checks if the collection
 contains a given value.

* Visibility: **public**

#### Arguments
* $needle **mixed**

### count

    integer PHPCollections\Collections\AbstractCollection::count()

Returns the length of the collection.

* Visibility: **public**

### diff

    AbstractCollection PHPCollections\Collections\AbstractCollection::diff(AbstractCollection $collection)

Gets the difference between two collections.

* Visibility: **public abstract**

#### Arguments
* $collection **\PHPCollections\Collections\AbstractCollection**

### exists

    boolean PHPCollections\Collections\AbstractCollection::exists(mixed $offset)

Checks if the given index
exists in the collection.

* Visibility: **public**

### fill

    void PHPCollections\Collections\AbstractCollection::fill()

Fills the collection with a set of data.

* Visibility: **public**

### first

    mixed PHPCollections\Collections\AbstractCollection::first()

Gets the first element in the collection.

* Visibility: **public**

#### Throws
**\OutOfRangeException**

### isEmpty

    boolean PHPCollections\Collections\AbstractCollection::isEmpty()

Checks if the collection is empty.

* Visibility: **public**

#### Throws
**\OutOfRangeException**

### jsonSerialize

    array PHPCollections\Collections\AbstractCollection::jsonSerialize()

Defines the behavior of the collection
when json_encode is called.

* Visibility: **public**

### last

    mixed PHPCollections\Collections\AbstractCollection::last()

Gets the last element in the collection.

* Visibility: **public**

### toArray

    array PHPCollections\Collections\AbstractCollection::toArray()

Returns a plain array with
your dictionary data.

* Visibility: **public**

### slice

    ?AbstractCollection PHPCollections\Collections\AbstractCollection::slice(int $offset, ?int $length = null)

 Returns a portion of the collection.

* Visibility: **public abstract**

#### Arguments
* $offset **int**
* $length **int**

### sum

    float PHPCollections\Collections\AbstractCollection::sum(callable $callback)

Returns the sum of a set of values.

* Visibility: **public**

#### Arguments
* $callback **callable**

#### Throws
**\OutOfRangeException**