# iBundle

iBundle is an "improved" Bundles manager for the Laravel PHP framework. iBundle allows you to install 'i'Bundles and activate them from the Artisan command line interface that we all love. If a new Bundle is installed using iBundle artisan commands, the new bundles will be made to be compatible with iBundle. You will never have to go to your <code>applications/bundles.php</code> file again.

- **Author:** Neo Ighodaro
- **Website:** [http://github.com/CreativityKills/iBundle](http://github.com/CreativityKills/iBundle)
- **Version:** 1.0.0

## Copyright and License
iBundle was written by Neo Ighodaro (CreativityKills, LLC) for the Laravel framework.
iBundle is released under the MIT License. See the LICENSE file for details.

Copyright 2012 CreativityKills, LLC

## Changelog

### iBundle 1.0
- Initial release.

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

 to activate the Bundle on the fly. You can also optionally set the auto and handles parameter by adding a third and fourth argument. The auto parameter has to be a boolean and the fourth is for bundle routes.

<code>
	$ php artisan ibundle::install bundle_name true true handles
</code>

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
	$ php artisan ibundle::initialize bundle_name
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