<?php

class Ibundle_Available_Task extends Task {

	public function run($arguments)
	{
		$available = iBundle::available();

		if (empty($available)) throw new Exception("No iBundles are currently available.");

		$i = 0;
		foreach($available as $bundle => $config)
		{
			echo PHP_EOL.++$i.') '.$bundle;
		}
	}

}