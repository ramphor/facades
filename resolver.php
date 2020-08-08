<?php

namespace Ramphor\Facades;

use Ramphor\Facades\Proxy\wpdb;
use Ramphor\Logger\Logger;

if (!class_exists(Resolver::class)) {
    class Resolver
    {
        protected $instances = [];

        public function bind($name, $callable, $cacheInstance = true)
        {
            $this->instances[trim($name)] = array(
                'callable' => $callable,
                'cache' => $cacheInstance,
            );
        }

        /**
         * Resolve the facade instance
         *
         * @param string $name The cacade name
         * @return array Return include the resolved object and a flag cache object.
         */
        public function resolve($name)
        {
            if ($instances[$name]) {
                $cache = $instances[$name]['cache'];
                $callable = $instances[$name]['callable'];
                if (is_object($callable)) {
                    return array(
                        'instance' => $callable,
                        'cache' => $cache
                    );
                }
                if (is_callable($callable)) {
                    return array(
                        'instance' => call_user_func($callable),
                        'cache' => $cache,
                    );
                }
            }
        }
    }

    $resolver = new Resolver();
    $resolver->bind('logger', Logger::instance(), true);
    $resolver->bind('wpdb', new wpdb($GLOBALS['wpdb']), true);

    Facade::setFacadeResolver($resolver);

    $facadeAlias = apply_filters('ramphor_facades_register_alias', array(
        'DB' => \Ramphor\Facades\DB::class,
        'Logger' => \Ramphor\Facades\Logger::class,
    ));
    foreach ($facadeAlias as $aliasClass => $originalClass) {
        // Create the alias if the class is exists
        if (!class_exists($aliasClass)) {
            class_alias($originalClass, $aliasClass, true);
        }
    }
}
