<?php namespace iBundle\Tasks;

use File;
use iBundle;
use Ibundle_Base_Task;
use Laravel\CLI\Command as Command;

class Main {

	/**
	 * Starts the process of installing a bundle as an iBundle. Setting
	 * the second parameter to true activates the ibundle on the fly.
	 *
	 * <code>
	 * 	$ php artisan ibundle::install bundle [true]
	 * </code>
	 *
	 * @param  array  $arguments
	 * @return  null
	 */
	public function install($arguments = array())
	{
		$bundle = array_get($arguments, 0, false);

		if ($bundle === false or empty($bundle))
		{
			Ibundle_Base_Task::error('Invalid iBundle name.');
		}

		// Laravel do your thing.
		Command::run(array('bundle:install', $bundle));

		// ...start tracking bundle
		$this->track(array($bundle));

		echo PHP_EOL;

		// Activate bundle on the fly if requested
		if ($activate = array_get($arguments, 1)) $this->activate($arguments);

		// Installed!
		echo "Finalizing iBundle [{$bundle}] installation... Done!";
	}

	/**
	 * Activate a tracked bundle.
	 *
	 * <code>
	 * 	$ php artisan ibundle::activate bundle
	 * </code>
	 *
	 * @param  array  $arguments
	 * @return  null
	 */
	public function activate($arguments = array())
	{
		$bundle = array_get($arguments, 0);

		if ($bundle === false or empty($bundle))
		{
			Ibundle_Base_Task::error('Invalid iBundle name.');
		}

		if (  ! array_key_exists($bundle, iBundle::available(true)))
		{
			Ibundle_Base_Task::error("iBundle is not tracking [{$bundle}].");
		}

		if (array_key_exists($bundle, iBundle::activated()))
		{
			Ibundle_Base_Task::error("iBundle [{$bundle}] is already active.");
		}

		if ( ! iBundle::activate($bundle))
		{
			Ibundle_Base_Task::error("Could not activate [{$bundle}].");
		}

		echo "Activating iBundle [{$bundle}]... Done!";
	}

	/**
	 * Deactivate an activated iBundle.
	 *
	 * <code>
	 * 	$ php artisan ibundle::deactivate bundle
	 * </code>
	 *
	 * @param  array  $arguments
	 * @return  null
	 */
	public function deactivate($arguments = array())
	{
		$bundle = array_get($arguments, 0);

		if ($bundle === false or empty($bundle))
		{
			Ibundle_Base_Task::error('Invalid iBundle name.');
		}

		if ( ! array_key_exists($bundle, iBundle::available(true)))
		{
			Ibundle_Base_Task::error("iBundle is not tracking [{$bundle}].");
		}

		if ( ! array_key_exists($bundle, iBundle::activated()))
		{
			Ibundle_Base_Task::error("iBundle [{$bundle}] is not active.");
		}

		if ( ! iBundle::deactivate($bundle))
		{
			Ibundle_Base_Task::error("Could not deactivate [{$bundle}].");
		}

		echo "Deactivating iBundle [{$bundle}]... Done!";
	}

	/**
	 * Starts tracking an existing bundle.
	 *
	 * <code>
	 * 	$ php artisan ibundle::track bundle [handles]
	 * </code>
	 *
	 * @param  array  $arguments
	 * @return  null
	 */
	public function track($arguments = array())
	{
		$bundle = array_get($arguments, 0);
		$handles = array_get($arguments, 1, 'null');

		if ($bundle === false or empty($bundle))
		{
			Ibundle_Base_Task::error('Invalid iBundle name.');
		}

		if (array_key_exists($bundle, iBundle::available(true)))
		{
			Ibundle_Base_Task::error("iBundle is already tracking [{$bundle}].");
		}

		$bundle_dir = path('bundle').$bundle.DS;
		$ibundle_dir = ibundle_config('path').$bundle.DS;

		// If the bundle directory and the iBundle directory are not the same then
		// attempt to move/copy the ibundle to the right directory.
		if ($bundle_dir !== $ibundle_dir and file_exists($bundle_dir) and ! file_exists($ibundle_dir))
		{
			// Method to use
			$method = ibundle_config('track_method') === 'copy' ?
				File::cpdir($bundle_dir, $ibundle_dir) :
				File::mvdir($bundle_dir, $ibundle_dir);

			if ( ! $method) Ibundle_Base_Task::error("Unable to drop bundle into iBundle directory.");
		}

		//  if theres no ibundle.json file then create one. Thats the marker that ibundle is tracking
		// a bundle. WIthout this file, ibundle cannot see the bundle.
		if (file_exists($ibundle_dir) and ! file_exists($ibundle_dir.'ibundle.json'))
		{
			// Customize ibundle.json meta data
			$meta_data = str_replace(
				array('@auto', '@path', '@handles'),
				array('true', '"path: '.addslashes($ibundle_dir).'"', $handles),
				File::get(IBUNDLE_ROOT.'storage/ibundle_template.json')
			);

			$tracking = File::put($ibundle_dir.'ibundle.json', $meta_data);

			if ( ! $tracking) Ibundle_Base_Task::error("Unable to add ibundle.json to bundle directory.");
		}

		echo "Tracking Bundle [{$bundle}]... Done!";
	}

	/**
	 * Stop tracking a bundle.
	 *
	 * <code>
	 * 	$ php artisan ibundle::untrack bundle
	 * </code>
	 *
	 * @param  array  $arguments
	 * @return  null
	 */
	public function untrack($arguments = array())
	{
		$bundle = array_get($arguments, 0);

		if ($bundle === false or empty($bundle))
		{
			Ibundle_Base_Task::error('Invalid iBundle name.');
		}

		if ( ! array_key_exists($bundle, iBundle::available(true)))
		{
			Ibundle_Base_Task::error("iBundle [{$bundle}] is not being tracked.");
		}

		// JSON file
		$json_file = ibundle_config('path').$bundle.DS.'ibundle.json';

		echo "Untracking bundle [{$bundle}]...";
		echo File::delete($json_file) ? "Done" : "Failed";
	}

	/**
	 * Gets a list of tracked bundles. Activated or not.
	 *
	 * <code>
	 * 	$ php artisan ibundle::available [true]
	 * </code>
	 *
	 * @return  null
	 */
	public function available($arguments =  array())
	{
		$available = iBundle::available();

		if (empty($available))
		{
			Ibundle_Base_Task::error("No iBundles are currently being tracked.");
		}

		$i = 0;

		foreach($available as $bundle => $config)
		{
			// Show path?
			$config = (array_get($arguments, 0) === 'true') ? " [path: {$config}]" : '';

			echo PHP_EOL.++$i.") {$bundle}{$config}";
		}
	}

	/**
	 * Gets a list of activated ibundles.
	 *
	 * <code>
	 * 	$ php artisan ibundle::activated [true]
	 * </code>
	 *
	 * @return  null
	 */
	public function activated($arguments = array())
	{
		$activated = iBundle::activated();

		if (empty($activated))
		{
			Ibundle_Base_Task::error("No iBundles are currently active.");
		}

		$i = 0;

		foreach($activated as $bundle => $config)
		{
			// Show path?
			$config = (array_get($arguments, 0) === 'true') ? ' ['.$config['location'].']' : '';

			echo PHP_EOL.++$i.") {$bundle}{$config}";
		}
	}
}