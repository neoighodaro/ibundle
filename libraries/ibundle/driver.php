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

use Bundle;
use Laravel\File as Laravel_File;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

abstract class Driver {

	/**
	 * List of available iBundles.
	 *
	 * @var array
	 */
	public $available = array();

	/**
	 * Modified data of current entity waiting to be saved.
	 *
	 * @var array
	 */
	protected $_data = array();

	/**
	 * List of activated ibundles.
	 *
	 * @var array
	 */
	public $activated = array();

	/**
	 * List of registered bibundles.
	 *
	 * @var array
	 */
	public $registered = array();

	/**
	 * Fetches activated bundle list from the filesystem.
	 *
	 * @return array
	 */
	protected abstract function fetch();

	/**
	 * Saves activated bundle list to filesystem.
	 *
	 * @return boolean
	 */
	protected abstract function save();

	/**
	 * Activate a valid iBundle.
	 *
	 * @param  string  $bundle
	 * @return boolean
	 */
	public function activate($bundle)
	{
		// Activated bundles
		$bundles = $this->activated();

		// Already activated or iBundle is not available.
		if ( ! array_key_exists($bundle, $this->available()) or array_key_exists($bundle, $bundles))
			return false;

		// Path to the iBundle JSON file
		$meta_data = ibundle_config('path').$bundle.DIRECTORY_SEPARATOR.'ibundle.json';

		// You need to chmod the ibundle.json file.
		if ( ! Laravel_File::exists($meta_data) or ! is_readable($meta_data)) return false;

		// Get meta data proper
		$meta_data = (array) json_decode(Laravel_File::get($meta_data));

		// Invalid meta data. grr.
		if ( ! $this->valid_meta_data($meta_data)) return false;

		// Set as activated, along with meta data
		$this->activated[$bundle] = $meta_data;

		// Set fresh data
		$this->_data = $this->_prep_data($this->activated);

		// Save
		return (bool) $this->save();
	}

	/**
	 * Deactivate an activated iBundle.
	 *
	 * @param  string $bundle
	 * @return  boolean
	 */
	public function deactivate($bundle)
	{
		// Not activated before.
		if ( ! array_key_exists($bundle, $this->activated())) return false;

		// Remove bundle
		unset($this->activated[$bundle]);

		// Set data to be saved
		$this->_data = $this->_prep_data($this->activated);

		return (bool) $this->save();
	}

	/**
	 * Get a list of activated iBundles.
	 *
	 * @return array
	 */
	public function activated()
	{
		if (empty($this->activated))
		{
			$this->activated = $this->fetch();
		}

		if (is_string($this->activated))
		{
			$this->activated = $this->_prep_data($this->activated);
		}

		return (array) $this->activated;
	}

	/**
	 * Loops through bundles folder and gets a list of valid iBundle bundles.
	 *
	 * @param  boolean $force_check
	 * @return array
	 */
	public function available($force_check = false)
	{
		if (empty($this->available) or $force_check === true)
		{
			// Path
			$path = ibundle_config('path');

			// Recursively grab files
			$bundles = iterator_to_array(
				new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path))
			);

			// Available iBundles
			$available = array();

			// Loop through all the files found. We are looking for folders with an
			// ibundle.json file
			array_map(
				function($path) use (&$available)
				{
					if(strpos($path, "ibundle.json") !== false)
					{
						// directory name
						$directory_name = pathinfo(dirname($path), PATHINFO_BASENAME);

						// Add path to list of available iBundles
						$available[$directory_name] = dirname($path);
					}
				},
				$bundles
			);

			$this->available = $available;
		}

		return (array) $this->available;
	}

	/**
	 * Starts the activated ibundles as bundles.
	 *
	 * @return array
	 */
	public function register()
	{
		if (empty($this->registered))
		{
			foreach($this->activated() as $bundle => $config)
			{
				if( ! Laravel_File::exists(ibundle_config('path').$bundle))
				{
					// Remove it and skip registration
					$this->deactivate($bundle);
					continue;
				}

				if ( ! Bundle::exists($bundle))
				{
					// register the bundle using the ibundle.json data
					Bundle::register($bundle, $config);

					if (isset($config['auto']) and $config['auto'] === true)
					{
						// Start the registered bundle
						Bundle::start($bundle);

						if (Bundle::started($bundle))
						{
							$this->registered[$bundle] = $config;
						}
					}
				}
			}
		}

		return (array) $this->registered;
	}

	/**
	 * Prepare data for saving. Can be overwritten by each driver by secifying a
	 * methd identicat to this.
	 *
	 * @param  array|mixed $data
	 * @return  string
	 */
	protected function _prep_data($data)
	{
		return is_string($data) ? unserialize($data) : serialize($data);
	}

	/**
	 * Checks to see if the ibundle.json file contains vaild JSON data.
	 *
	 * @param  array $meta_data
	 * @return bool
	 */
	protected function valid_meta_data($meta_data)
	{
		// Invalid JSON file.
		if ($meta_data === null) return false;

		// Type cast to array
		$meta_data = (array) $meta_data;

		// Required keys
		$expected = array('auto', 'handles', 'location');

		// Is a valid json file
		$is_valid = true;

		foreach($expected as $key)
		{
			if ( ! array_key_exists($key, $meta_data))
			{
				// Stop searching.
				$is_valid = false;
				break;
			}
		}

		return $is_valid;
	}
}