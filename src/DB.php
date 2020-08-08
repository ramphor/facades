<?php
namespace Ramphor\Facades;

use RuntimeException;

class DB extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'wpdb';
    }
}
