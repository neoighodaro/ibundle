<?php

/**
 * The ibundle task is in charge of running tasks on ibundle using the
 * artisan cli. Here we use the IoC container to specify the service classes
 * for the tasks meythods.
 */

$dependency = new iBundle\Tasks\Main;

// Install
IoC::register('task: ibundle::install', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'install');
});

// Migrate
IoC::register('task: ibundle::migrate', function() use ($dependency)
{
    return new Ibundle_Base_Task($dependency, 'migrate');
});

// Activate
IoC::register('task: ibundle::activate', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'activate');
});

// Deactivate
IoC::register('task: ibundle::deactivate', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'deactivate');
});

// Track
IoC::register('task: ibundle::track', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'track');
});

// Untrack
IoC::register('task: ibundle::untrack', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'untrack');
});

// Available
IoC::register('task: ibundle::available', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'available');
});

// Activated
IoC::register('task: ibundle::activated', function() use ($dependency)
{
	return new Ibundle_Base_Task($dependency, 'activated');
});

// Initialize: Depreciated in 1.1.0!
IoC::register('task: ibundle::initialize', function()
{
	echo('NOTE: This method is depreciated, use the "ibundle::track" command instead.'.PHP_EOL.PHP_EOL);
	return IoC::resolve('task: ibundle::track');
});
