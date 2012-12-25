<?php

class NormalLaw
{
	private $_peak;

	public function __construct($minTaskCount, $maxTaskCount, $timeout)
	{
		parent::__construct($minTaskCount, $maxTaskCount);
		$this->_peak = $maxTaskCount;
	}

	public function generateTasks($time)
	{

	}
}