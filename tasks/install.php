<?php

class Ibundle_Install_Task extends Task {

	public function run($arguments)
	{
		// Bundle
		$bundle = array_get($arguments, 0);

		// Run via normal install methods
		Laravel\CLI\Command::run(array('bundle:install', $bundle));
		Laravel\CLI\Command::run(array('ibundle::initialize', $bundle));

		// Installed!
		echo PHP_EOL."Installing [{$bundle}] as iBundle... Done!";

		if (array_get($arguments, 1) === 'true')
		{
			echo PHP_EOL;
			Laravel\CLI\Command::run(array('ibundle::activate', $bundle));
		}
	}

}