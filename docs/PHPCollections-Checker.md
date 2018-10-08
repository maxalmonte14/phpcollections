PHPCollections\Checker
===============

An utility class for checking different type of data.

* Class name: Checker
* Namespace: PHPCollections

Methods
-------

### isEqual

    bool PHPCollections\Checker::isEqual(mixed $firstValue, mixed $secondValue, string $message)

Checks that two values are equals.

* Visibility: **public static**

#### Arguments
* $value **mixed**
* $message **string**

#### Throws
* **\InvalidArgumentException**

### isObject

    bool PHPCollections\Checker::isObject(mixed $value, string $message)

Checks that a value is and object if not throws an exception.

* Visibility: **public static**

#### Arguments
* $value **mixed**
* $message **string**

#### Throws
* **\InvalidArgumentException**

### objectIsOfType

    bool PHPCollections\Checker::objectIsOfType(object $object, string $type, string $message)

Checks that an object is of the desired type, if not throws an exception.

* Visibility: **public static**

#### Arguments
* $object **object**
* $type **string**
* $message **string**

#### Throws
* **\InvalidArgumentException**

### valueIsOfType

    bool PHPCollections\Checker::valueIsOfType(mixed $value, mixed $valueType, string $message)

Checks that a Dictionary key or value is of the desire type, if not throws an exception.

* Visibility: **public static**

#### Arguments
* $value **mixed**
* $valueType **mixed**
* $message **string**

#### Throws
* **\InvalidArgumentException**
