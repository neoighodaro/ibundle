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
	'iBundle'	=> __DIR__.'/libraries/ibundle.php',
));

Autoloader::namespaces(array(
	'iBundle'	=> __DIR__.'/libraries/ibundle',
));


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
		with(new iBundle\Config)->set($key, $value);
	}

	return with(new iBundle\Config)->get($key);
}