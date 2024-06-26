<?php
namespace Scurri\Utils;

trait Singleton{
    private static object $instance;

    /**
     * @return static
     */
    public static function instance(): object{
        return static::$instance;
    }

    public static function _instantiate(){
        $class = static::class;
        static::$instance = new $class;
    }
}
?>