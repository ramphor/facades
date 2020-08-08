<?php
namespace Ramphor\Facades\Proxy;

class wpdb
{
    /**
     * WordPress Database Access Abstraction Object
     *
     * @var wpdb
     * @link https://developer.wordpress.org/reference/classes/wpdb/
     */
    protected $wpdb;

    /**
     * The wpdb proxy constructor
     *
     * @param wpdb $wpdb
     */
    public function __construct(&$wpdb)
    {
        if (!$wpdb instanceof wpdb) {
            // Please read more info at https://developer.wordpress.org/reference/classes/wpdb/
            error_log('The wpdb must be instance of class wpdb.');
            return;
        }
        $this->wpdb = $wpdb;
    }

    public function get_wpdb()
    {
        return $this->wpdb;
    }

    public function __call($name, $args)
    {
        $callback = array($this->wpdb, $name);
        if (is_callable($callback)) {
            return call_user_func_array($callback, $args);
        }
    }

    public function get_table($name)
    {
        return sprintf(
            '%s%s',
            $this->wpdb,
            $name
        );
    }
}
