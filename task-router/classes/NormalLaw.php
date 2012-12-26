<?php

class NormalLaw
{
	private $_peak;

	public function __construct($minTaskCount, $maxTaskCount, $timeout)
	{
		parent::__construct($minTaskCount, $maxTaskCount);
		$this->_peak = $maxTaskCount;
	}

	public function generateTasks($x)
	{
		$peak = 1000;
		$q = 0.2;
		$return = 0;

		$expArg = -((($x - $peak) * ($x - $peak)) / (2 * ($q * $q)));
		$return = 1 / ($q * sqrt(2 * pi())) * exp($expArg);
		return $return;
	}
}