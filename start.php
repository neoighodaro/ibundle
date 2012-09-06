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

// Bundle root
define('IBUNDLE_ROOT', __DIR__.DIRECTORY_SEPARATOR);

/*
|----------------------------------------------------------------------------------------------
| Register iBundle Autoloaders
|----------------------------------------------------------------------------------------------
|
| The autoloaders direct Laravel to the right classes, and helps it do its
| job a lot faster and better.
|
 */

Autoloader::map(array(
	'iBundle'		=> IBUNDLE_ROOT.'libraries/ibundle.php',
	'Ibundle_Base_Task'	=> IBUNDLE_ROOT.'tasks/base.php',
	'iBundle\\Tasks\\Main'	=> IBUNDLE_ROOT.'tasks/main.php',
));

Autoloader::namespaces(array(
	'iBundle'		=> IBUNDLE_ROOT.'libraries/ibundle',
));

// Load the artisan dependencies
require IBUNDLE_ROOT.'tasks/dependencies.php';

/*
|----------------------------------------------------------------------------------------------
| Register the activated bundles.
|----------------------------------------------------------------------------------------------
|
| Register the activated bundles, thus making it available to other parts of
| Laravel.
|
 */

iBundle::register();


/**
 * Helper to get and set (optional) a config item from the iBundle configuration file.
 *
 * @param  string  $key
 * @param  mixed $value
 * @return mixed
 */
function ibundle_config($key, $value = '')
{
	if ($value !== '')
	{
		// Set a config key value
		with(new iBundle\Config)->set($key, $value);
	}

	return with(new iBundle\Config)->get($key);
}