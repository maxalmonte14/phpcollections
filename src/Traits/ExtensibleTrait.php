<?php

namespace PHPCollections\Traits;

trait ExtensibleTrait
{
    /**
     * @var array
     */
    protected static $extensionMethods;

    /**
     * Adds a new extension method.
     *
     * @param string   $name
     * @param callable $method
     *
     * @return void
     */
    public static function addExtensionMethod(string $name, callable $method): void
    {
        self::$extensionMethods[$name] = $method;
    }

    /**
     * Calls an extension method.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return call_user_func_array(self::$extensionMethods[$name], $arguments);
    }


}