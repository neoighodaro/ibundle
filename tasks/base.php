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
		$this->_action     = $action;
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
		if( ! empty($this->_action) and method_exists($this->_dependency, $this->_action))
		{
			$this->_dependency->{$this->_action}($arguments);
		}
		else
		{
			static::error('Sorry, iBundle cant find that method!');
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