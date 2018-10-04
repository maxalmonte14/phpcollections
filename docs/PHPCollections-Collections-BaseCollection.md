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

### count

    integer PHPCollections\Collections\BaseCollection::count()

Returns the length of the collection.

* Visibility: **public**

### exists

    boolean PHPCollections\Collections\BaseCollection::exists(mixed $offset)

Checks if the given index
exists in the collection.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### jsonSerialize

    array PHPCollections\Collections\BaseCollection::jsonSerialize()

Defines the behavior of the collection
when json_encode is called.

* Visibility: **public**

### toArray

    array PHPCollections\Collections\BaseCollection::toArray()

Returns a plain array with
your dictionary data.

* Visibility: **public**
