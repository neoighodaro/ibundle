# iBundle

iBundle is an "improved" Bundles manager for the Laravel PHP framework. iBundle allows you to install 'i'Bundles and activate them from the Artisan command line interface that we all love. If a new Bundle is installed using iBundle artisan commands, the new bundles will be made to be compatible with iBundle. You will never have to go to your <code>applications/bundles.php</code> file again.

- **Author:** Neo Ighodaro
- **Website:** [http://github.com/CreativityKills/iBundle](http://github.com/CreativityKills/iBundle)
- **Version:** 1.1.0

## Copyright and License
iBundle was written by Neo Ighodaro (CreativityKills, LLC) for the Laravel framework.
iBundle is released under the MIT License. See the LICENSE file for details.

Copyright 2012 CreativityKills, LLC

## Changelog

### iBundle 1.1.0
- Added a few configuration file items.
- Depreciated ibundle::initialize in favor of a more understandable ibundle::track
- Rewrote the task classes. Tasks are now called using IoC containers.

### iBundle 1.0.0
- Initial release.

## Terminology

### Installing
Installing an ibundle simply means iBundle uses Laravel to fetch bundles, then starts tracking it by moving/copying the bundle to the ibundle directory and adding its tracking file to the bundles root directory.

### Tracking / Untracking
When bundles are tracked it means that its can be worked on by iBundle. It can be activated / deactivated etc. Untracked bundles are not recognized as iBundle bundles and thus cannot be activated by iBundle.

### Activating / Deactivating
When a bundle is acivated in iBundle, its simply registered. Its the equivalent of adding it to your <code>application/bundles.php</code> file. When its deactivated, its the equivalent of removing it from your <code>application/bundles.php file</code>. When iBundles are activated, depending on their auto (load) setting which can be found in the <code>ibundle.json</code> file, the Bundle could be started. This is the equivalent of adding a bundle to <code>application/bundles.php</code> with the auto config set to true.

## Documentation

### Installation
Installing iBundle. You can install iBundle using the Laravel artisan console

<code>
	$ php artisan bundle:install ibundle
</code>

or by downloading the zip from Github and unzipping it in your bundles directory.

After installing the bundle, you can now activate the bundle in your applications/bundles.php

<code>
	return array(
		'ibundle' => array('auto' => true),
	);
</code>.

Its a good idea to use iBundle to manage all your bundles, and thus it will be better to remove all the already listed bundles in the application/bundles.php file. Later, we will see how to start tracking bundles that are not being tracked by iBundle.

### Installing A Bundle with iBundle
Installing a bundle with iBundle is simple, all you have to do is run artisan:

<code>
	$ php artisan ibundle::install bundle_name
</code>

...Just as you would install a bundle normally on Laravel. You can optionally add an option

<code>
	$ php artisan ibundle::install bundle_name true
</code>

 to activate the Bundle on the fly.

### Activating an iBundle
After an iBundle is being tracked by iBundle, you can activate the bundle (activating the bundle means the bundle will be registered with Bundle::register and if the ibundle config is set to auto then it will be started). To activate a bundle on artisan CLI use:

<code>
	$ php artisan ibundle::activate bundle_name
</code>

### Deactivating an iBundle
You can decide to deactivate a bundle altogether thus leaving it unregistered and unseen by Laravel. Any bundle thats not activated WILL not be registered and thus even calling Bundle::start('bundle_name') will not start the bundle. To deactivate a bundle:

<code>
	$ php artisan ibundle::deactivate bundle_name
</code>

### Available iBundles
Sometimes you want to see the bundles tracked by iBundle whether activated or not, yoyu can do that by:

<code>
	$ php artisan ibundle::available
</code>

### Activated Bundles
You can see the list of activated iBundles by using:

<code>
	$ php artisan ibundle::activated
</code>

### Tracking and Untracking a bundle

#### Track
Sometimes you have already started using some bundles but you want to track it using iBundle. Then you can:

<code>
	// You can optionally add a second parameter, this will be set as the "handles" setting
	// its useful if you require routes for the bundle to work
	$ php artisan ibundle::track bundle_name
</code>

That code looks for the bundle in the default bundles directory, and attempts to start tracking it.

#### Untrack
To stop tracking a bundle

<code>
	$ php artisan ibundle::untrack bundle_name
</code>

NOTE: If you changed the path of the iBundles directory in the config file then you will have to manually move the bundle back to your bundles folder.


### Developers
You can add a driver to the iBundle bundle. If you do then please send me a pull request so i can add it to iBundle. A database, redis etc. driver might be nice.