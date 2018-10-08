PHPCollections\Collections\Stack
===============

A generic LIFO Stack.

* Class name: Stack
* Namespace: PHPCollections\Collections
* This class implements: Countable

Properties
----------

### $data

    private array $data

The data container.

* Visibility: **private**

### $type

    private mixed $type

The type of the values
for this Stack.

* Visibility: **private**

Methods
-------

### __construct

    void PHPCollections\Collections\Stack::__construct(string $type)

Creates a new Stack.

* Visibility: **public**

#### Arguments
* $type **string**

### clear

    void PHPCollections\Collections\Stack::clear()

Clears the data values.

* Visibility: **public**

### count

    int PHPCollections\Collections\Stack::count()

Returns the length of the Stack.

* Visibility: **public**

### isEmpty

    bool PHPCollections\Collections\Stack::isEmpty()

Checks if the stack is empty.

* Visibility: **public**

### peek

    mixed PHPCollections\Collections\Stack::peek()

Gets the element at
the end of the Stack.

* Visibility: **public**

### pop

    mixed PHPCollections\Collections\Stack::pop()

Pops the element at
the end of the stack.

* Visibility: **public**

### push

    mixed PHPCollections\Collections\Stack::push(mixed $value)

Adds a new element at
the end of the Stack.

* Visibility: **public**

#### Arguments
* $value **mixed**

#### Throws
* **\InvalidArgumentException**
