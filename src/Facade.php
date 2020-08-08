<?php
namespace Ramphor\Facades;

use RuntimeException;

abstract class Facade
{
    protected static $resolver;
    protected static $resolvedInstance;

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }


    /**
     * Resolve the facade root instance from the container.
     *
     * @param  object|string  $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        if (static::$resolver) {
            $result = static::$resolver->resolve($name);
            if ($result['cache']) {
                return static::$resolvedInstance[$name] = $result['instance'];
            }
        }
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Set the resolver instance.
     *
     * @param  \Ramohor\Facades\Resolver  $resolver
     * @return void
     */
    public static function setFacadeResolver($resolver)
    {
        static::$resolver = $resolver;
    }


    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return call_user_func_array(
            array($instance, $method),
            $args
        );
    }
}
