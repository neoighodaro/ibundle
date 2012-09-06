<?php

class Ibundle_Untrack_Task extends Task {

	public function run($arguments)
	{
		// Bundle
		$bundle = array_get($arguments, 0);

		if ( ! array_key_exists($bundle, iBundle::available(true)))
			throw new Exception("iBundle [{$bundle}] is not installed.");

		// Delete the ibundle.json file
		$json_file = ibundle_config('path').$bundle.DS.'ibundle.json';

		echo "Untracking iBundle [{$bundle}]... ";
		echo File::delete($json_file) ? "Done!" : "Failed";
	}

}