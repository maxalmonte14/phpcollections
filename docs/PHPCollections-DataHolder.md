PHPCollections\DataHolder
===============

A class for storing and managing data.

* Class name: DataHolder
* Namespace: PHPCollections
* This class implements: ArrayAccess, IteratorAggregate

Properties
----------

### $container

    private array $container

The array for storing data.

* Visibility: **private**

Methods
-------

### __construct

    void PHPCollections\DataHolder::__construct(array $data)

Initializes the container property.

* Visibility: **public**

#### Arguments
* $data **array**

### getContainer

    array PHPCollections\DataHolder::getContainer()

Returns the container array.

* Visibility: **public**

### getIterator

    \ArrayIterator PHPCollections\DataHolder::getIterator()

Returns an array iterator for
the container property.

* Visibility: **public**

### offsetExists

    boolean PHPCollections\DataHolder::offsetExists(mixed $offset)

Checks if an offset exists in the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### offsetGet

    ?mixed PHPCollections\DataHolder::offsetGet(mixed $offset)

Gets a value from the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### offsetSet

    void PHPCollections\DataHolder::offsetSet(mixed $offset, mixed $value)

Sets a value into the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**
* $value **mixed**

### offsetUnset

    void PHPCollections\DataHolder::offsetUnset(mixed $offset)

Unsets an offset from the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### setContainer

    void PHPCollections\DataHolder::setContainer(array $data)

Sets the container array.

* Visibility: **public**

#### Arguments
* $data **array**
