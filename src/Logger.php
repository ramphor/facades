<?php
namespace Ramphor\Facades;

class Logger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'logger';
    }
}
