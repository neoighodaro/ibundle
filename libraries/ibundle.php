<?php
/**
 * iBundle - Laravel bundles on steroids.
 *
 * iBundle is a smart bundle manager for Laravel. Helps you manage Laravel
 * Bundles using the Artisan cli we've all come to know and love.
 *
 * @author Neo Ighodaro <jeeniors@gmail.com>
 * @category Laravel
 * @package  iBundle
 * @link      http://github.com/CreativityKills/iBundle
 * @copyright 2012 CreativityKills, LLC
 */

class iBundle {

	/**
	 * iBundle\Driver class instance.
	 *
	 * @var iBundle\Driver
	 */
	public static $instance;

	/**
	 * Gets a singleton of the iBundle\Driver class.
	 *
	 * @return iBundle\Driver
	 */
	public static function instance()
	{
		if (static::$instance === null)
		{
			// Get iBundle active driver
			$driver = 'iBundle\\Driver\\'.ucfirst(ibundle_config('driver'));

			// Instantiate driver.
			static::$instance = new $driver;
		}

		return static::$instance;
	}

	/**
	 * Magically call a method from the iBundle\Driver class.
	 *
	 * @param  string $method
	 * @param  array $parameters
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		return call_user_func_array(array(static::instance(), $method), $parameters);
	}
}