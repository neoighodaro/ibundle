<?php

class Ibundle_Base_Task extends Task {

	/**
	 * Action to carry out.
	 *
	 * @var string
	 */
	public $_action = '';

	/**
	 * Dependency class.
	 *
	 * @var iBundle\Tasks
	 */
	public $_dependency;

	/**
	 * Sets the action to be carried out.
	 *
	 * @param string  $action
	 * @return null
	 */
	public function __construct($dependency, $action)
	{
		$this->_action = $action;
		$this->_dependency = $dependency;
	}

	/**
	 * Run a ibundle command.
	 *
	 * @param  array  $arguments
	 * @return void
	 */
	public function run($arguments = array())
	{
		// If no arguments were passed to the task, we will just migrate
		// to the latest version across all bundles. Otherwise, we will
		// parse the arguments to determine the bundle for which the
		// database migrations should be run.
		if (empty($this->_action))
		{
			throw new Exception('Sorry, iBundle cant find that method!');
		}
		else
		{
			if(method_exists($this->_dependency, $this->_action))
			{
				$this->_dependency->{$this->_action}($arguments);
			}
			else
			{
				throw new Exception("Sorry iBundle could not figure out what you were trying to do.");
			}
		}
	}

	/**
	 * Throws a common error exception.
	 *
	 * @param  string $message
	 * @return  null
	 * @throws  Exception
	 */
	public static function error($message)
	{
		throw new Exception($message);
	}
}