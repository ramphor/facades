<?php
namespace Ramphor\Facades\Proxy;

use BadMethodCallException;

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
        $this->wpdb = $wpdb;
    }

    public function get_wpdb()
    {
        return $this->wpdb;
    }

    public function convertCamelCaseMethodName($matches)
    {
        if (isset($matches[1])) {
            return '_' . strtolower($matches[1]);
        }
    }

    public function __call($name, $args)
    {
        $callback = array($this->wpdb, preg_replace_callback(
            '/([A-Z])/',
            array($this, 'convertCamelCaseMethodName'),
            $name
        ));
        if (is_callable($callback)) {
            return call_user_func_array($callback, $args);
        }
        throw new BadMethodCallException(sprintf('Call the undefined method %s::%s', __CLASS__, $name));
    }

    public function get_table($name)
    {
        return sprintf(
            '%s%s',
            $this->wpdb->prefix,
            $name
        );
    }
}
