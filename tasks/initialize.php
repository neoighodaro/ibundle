<?php

class Ibundle_Initialize_Task extends Task {

	public function run($arguments)
	{
		// Bundle
		$bundle = array_get($arguments, 0);
		$handles = array_get($arguments, 1, 'null');

		if (array_key_exists($bundle, iBundle::available(true)))
			throw new Exception("[{$bundle}] is already an iBundle.");

		// The expected directory.
		$ibundle_dir = ibundle_config('path').$bundle.DIRECTORY_SEPARATOR;

		// Bundle default directory
		$bundle_dir = path('bundle').$bundle.DIRECTORY_SEPARATOR;

		if (file_exists($bundle_dir) and ! file_exists($ibundle_dir))
		{
			try
			{
				// Move to iBundle directory
				File::mvdir($bundle_dir, $ibundle_dir);

				// Continue
				echo PHP_EOL."...moving bundle '{$bundle}' to iBundle directory...".PHP_EOL;
			}
			catch(Exception $e)
			{
				try
				{
					// Try to remove bundle
					File::rmdir($bundle_dir);
				}
				catch(Exception $e)
				{
				}

				throw new Exception("An error occurred while moving to iBundle. Make sure the iBundle directory exists and is writable before you try again.");
			}
		}

		if (file_exists($ibundle_dir) and ! file_exists($ibundle_dir.'ibundle.json'))
		{
			try
			{
				// Copy template
				File::put($ibundle_dir.'ibundle.json', File::get(Bundle::path('ibundle').'storage/ibundle_template.json'));
			}
			catch(Exception $e)
			{
				throw new Exception("Unable to make bundle compliant with iBundle. You can manually add an ibundle.json file to the bundle root to make the bundle compliant.");
			}
		}

		// Customize meta data
		$meta_data = str_replace(
			array('@auto', '@path', '@handles'),
			array('true', '"path: '.addslashes($ibundle_dir).'"', $handles),
			File::get($ibundle_dir.'ibundle.json')
		);

		// Resave
		File::put($ibundle_dir.'ibundle.json', $meta_data);

		echo "Initiatiazing Bundle [{$bundle}] as an iBundle... Done!";
	}

}