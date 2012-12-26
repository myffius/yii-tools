<?php

class Law
{
	/**
	 * ќтносительна€ точность нахождени€ максимума
	 */
	const EPS = 1;

	protected $_xMax;
	protected $_xMin;
	protected $_fMax;
	/**
	 * @var FrequencyFunction
	 */
	protected $_fFreq;

	//abstract function generateTasks($time);

	/**
	 * @param $minTaskCount
	 * @param $maxTaskCount
	 */
	public function __construct($FF, $xMinCellBound, $xMaxCellBound)
	{
		$this->_fFreq = $FF;

		$this->_xMin = $xMinCellBound;
		$this->_xMax = $xMaxCellBound;

		if ($this->_xMin > $this->_xMax)
			throw new Exception(get_class($this) . ': xMinCellBound can not be greater, than xMaxCellBound');

		$this->_fMax = $this->_fFreq->getMaxValueOfFunction($this->_xMin, $this->_xMax);

		//если не вызвать функцию Randomize, то при каждом запуске программы TfrGenerator
		//будет выдавать одну и ту же последовательность
		rand(0, 1);
	}

	/**
	 * √енерирует случайную величину, подчин€ющуюс€ закону распределени€,
	 * указанному в функции fFreq
	 */
	public function getNewValue()
	{
		do
		{
			$newValue = ($this->_xMax - $this->_xMin) * $this->floatRand(0, 100) + $this->_xMin;
		}
		while ($this->_fMax * $this->floatRand(0, 100) < $this->_fFreq->f($newValue));

		$return = $newValue;
		return $return;
	}

	protected function floatRand($min = null, $max = null)
	{
		if ($min === null && $max === null)
			return mt_rand() / 100;
		return mt_rand($min, $max) / 100;
	}
}