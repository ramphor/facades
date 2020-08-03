<?php

namespace Ramphor\Facades;

if (!class_exists(Resolver::class)) {
    class Resolver {
        public function bind($name, $callable, $cacheInstance = true) {
        }

        public function get($name) {
        }

        public function resolve($name) {
        }
    }
}
