<?php namespace iBundle;
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

use Laravel\Config as Laravel_Config;

class Config {

	/**
	 * Array containing the extended configuration.
	 *
	 * @var array
	 */
	public static $extend = array();

	/**
	 * Array containing the configuration.
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Extend the configuration with a custom configuration file.
	 *
	 * @param  array  $extend
	 * @return void
	 */
	public static function extend($extend)
	{
		if(is_string($extend))
		{
			$extend = Laravel_Config::get($extend);
		}

		static::$extend = (array) $extend;
	}

	/**
	 * Loads the config and merges in defaults and any extenders.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->config = array_merge(Laravel_Config::get('ibundle::ibundle'), static::$extend);
	}

	/**
	 * Get a config key from the config array.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key)
	{
		return array_get($this->config, $key);
	}

	/**
	 * Set a config key in the config array.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set($key, $value)
	{
		array_set($this->config, $key, $value);
	}

}