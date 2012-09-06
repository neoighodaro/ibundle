<?php

class iBundleTest extends PHPUnit_Framework_TestCase {

	/**
	 * Set up a mock environment to test iBundle.
	 *
	 * @return  null
	 */
	public function __construct()
	{
		// Start the bundle
		Bundle::start('ibundle');

		// Set test ibundle cache file
		$this->cache_file = ibundle_config('file', Bundle::path('ibundle').'storage/test.cache');
	}

	/**
	 * Removes the mock environment used during testing.
	 *
	 * @return  null
	 */
	public function __destruct()
	{
		// Remove test cache file
		@unlink($this->cache_file);
	}

	/**
	 * Test that iBundle\Base is instantiated.
	 *
	 * @return void
	 */
	public function testValidClassInstance()
	{
		$this->assertTrue(iBundle::instance() instanceof iBundle\Driver);
	}

	/**
	 * Test available iBundes.
	 *
	 * @return  null
	 */
	public function testAvailableList()
	{
		$this->assertTrue(is_array(iBundle::available()));
	}

	/**
	 * Test fetch activated bundles.
	 *
	 * @return null
	 */
	public function testFetchActivated()
	{
		$this->assertTrue(is_array(iBundle::activated()));
	}

	/**
	 * Test if bundle is activated and saved successfully.
	 *
	 * @return null
	 */
	public function testActivate()
	{
		$this->assertTrue(iBundle::activate('docs'));
	}

	/**
	 * Test if the activated bundle above is started.
	 *
	 * @return null
	 */
	public function testStartActivated()
	{
		$this->assertFalse(count(iBundle::register()) <= 0);
		$this->assertTrue(Bundle::started('docs'));
	}

	/**
	 * Test if a bundle activated above is deactivated here.
	 *
	 * @return null
	 */
	public function testDeactivate()
	{
		$this->assertTrue(iBundle::deactivate('docs'));
	}

}