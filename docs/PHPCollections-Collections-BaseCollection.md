PHPCollections\Collections\BaseCollection
===============

The base class for countable and
JSON serializable collections.

* Class name: BaseCollection
* Namespace: PHPCollections\Collections
* This is an **abstract** class
* This class implements: Countable, JsonSerializable

Properties
----------

### $dataHolder

    protected \PHPCollections\DataHolder $dataHolder

The data container.

* Visibility: **protected**

Methods
-------

### __construct

    void PHPCollections\Collections\BaseCollection::__construct(array $data)

Initializes the dataHolder property.

* Visibility: **public**

#### Arguments
* $data **array**

### clear

    void PHPCollections\Collections\BaseCollection::clear()

Reinitializes the dataHolder property.

* Visibility: **public**

### contains

    boolean PHPCollections\Collections\ArrayList::contains(mixed $needle)

 Checks if the collection
 contains a given value.

* Visibility: **public**

#### Arguments
* $needle **mixed**

### count

    integer PHPCollections\Collections\BaseCollection::count()

Returns the length of the collection.

* Visibility: **public**

### diff

    Basecollection PHPCollections\Collections\BaseCollection::diff(Basecollection $collection)

Gets the difference between two collections.

* Visibility: **public abstract**

### exists

    boolean PHPCollections\Collections\BaseCollection::exists(mixed $offset)

Checks if the given index
exists in the collection.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### first

    mixed PHPCollections\Collections\BaseCollection::first()

Gets the first element in the collection.

* Visibility: **public**

#### Throws
**\OutOfRangeException**

### isEmpty

    boolean PHPCollections\Collections\BaseCollection::isEmpty()

Checks if the collection is empty.

* Visibility: **public**

#### Throws
**\OutOfRangeException**

### jsonSerialize

    array PHPCollections\Collections\BaseCollection::jsonSerialize()

Defines the behavior of the collection
when json_encode is called.

* Visibility: **public**

### last

    mixed PHPCollections\Collections\BaseCollection::last()

Gets the last element in the collection.

* Visibility: **public**

### toArray

    array PHPCollections\Collections\BaseCollection::toArray()

Returns a plain array with
your dictionary data.

* Visibility: **public**

### slice

    ?BaseCollection PHPCollections\Collections\BaseCollection::slice(int $offset, ?int $length = null)

 Returns a portion of the collection.

* Visibility: **public abstract**

#### Arguments
* $offset **int**
* $length **int**