<?php

return array(

	/**
	 * The driver used to set and get the ibundles data.
	 */
	'driver'	=> 'File',

	/**
	 * The path where your iBundles will be saved.
	 */
	'path'	=> path('bundle'),

	/**
	 * File name of the cache file, used by iBundle file driver.
	 */
	'file'	=> IBUNDLE_ROOT.'storage/ibundle_activated.php.serialized',

	/**
	 * Move or Copy from bundles folder when tracking a bundle.
	 * Has no effect if the ibundles folder and bundles folder paths
	 * are the same.
	 */
	'track_method'	=> 'move',
);