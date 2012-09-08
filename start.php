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
 * @version   1.1.0
 */

/*
|----------------------------------------------------------------------------------------------
| Bundle Document Root
|----------------------------------------------------------------------------------------------
|
| This is defined for use throughout the Bundle. This is used instead of Laravel's
| Bundle::path('ibundle') so as to allow flexibility, so users can define the ibundle bundles
| name.
|
 */

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


/*
|----------------------------------------------------------------------------------------------
| Load task dependencies
|----------------------------------------------------------------------------------------------
|
| In v1.0 each task had a class of its own, its harder to maintain like that
| in v1.1.0 and above, tasks are called using the IoC container. Each artisan command has its
| unique identity that is always being looked for before each command is run,
| iBundle takes advantage of this to allow a flexible test class with injected dependency.
|
 */

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