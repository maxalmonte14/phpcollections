PHPCollections\Store
===============

A class for storing and managing data.

* Class name: Store
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

    void PHPCollections\Store::__construct(array $data)

Initializes the container property.

* Visibility: **public**

#### Arguments
* $data **array**

### getContainer

    array PHPCollections\Store::getContainer()

Returns the container array.

* Visibility: **public**

### getIterator

    \ArrayIterator PHPCollections\Store::getIterator()

Returns an array iterator for
the container property.

* Visibility: **public**

### offsetExists

    boolean PHPCollections\Store::offsetExists(mixed $offset)

Checks if an offset exists in the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### offsetGet

    ?mixed PHPCollections\Store::offsetGet(mixed $offset)

Gets a value from the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### offsetSet

    void PHPCollections\Store::offsetSet(mixed $offset, mixed $value)

Sets a value into the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**
* $value **mixed**

### offsetUnset

    void PHPCollections\Store::offsetUnset(mixed $offset)

Unsets an offset from the container.

* Visibility: **public**

#### Arguments
* $offset **mixed**

### setContainer

    void PHPCollections\Store::setContainer(array $data)

Sets the container array.

* Visibility: **public**

#### Arguments
* $data **array**
