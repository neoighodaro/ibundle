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
);