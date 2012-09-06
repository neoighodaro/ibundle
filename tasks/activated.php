<?php

class Ibundle_Activated_Task extends Task {

	public function run($arguments)
	{
		$activated = iBundle::activated();

		if (empty($activated)) throw new Exception("No iBundles are currently active.");

		$i = 0;
		foreach($activated as $bundle => $config)
		{
			echo PHP_EOL.++$i.') '.$bundle;
		}
	}

}