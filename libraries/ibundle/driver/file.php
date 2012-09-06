<?php namespace iBundle\Driver;
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

use iBundle\Driver;
use Laravel\File as Laravel_File;

class File extends Driver {

	/**
	 * Fetches activated bundle list from the filesystem.
	 *
	 * @return array
	 */
	protected function fetch()
	{
		return Laravel_File::get(ibundle_config('file'), null);
	}

	/**
	 * Saves activated bundle list to filesystem.
	 *
	 * @return boolean
	 */
	protected function save()
	{
		return (bool) Laravel_File::put(ibundle_config('file'), $this->_data);
	}
}