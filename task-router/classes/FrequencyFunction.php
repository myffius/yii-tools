<?php

class FrequencyFunction
{
	const EPS = 0.001;

	/**
	 * Определение максимального значения f(x) в указанном диапазоне.
	 * Используется метод деления отрезка пополам.
	 * Метод рассчитан на нахождение максимума только для унимодальных функций
	 */
	public function getMaxValueOfFunction($xMinOffset, $xMaxOffset)
	{
		$yMin  = $xMinOffset;
		$yMax  = $xMaxOffset;
		$fLeft = $this->f($yMin);
		$fRight= $this->f($yMax);

		$return = $this->f(($yMin + $yMax) / 2);

		while (abs($return - $fLeft) + abs($return - $fRight) > self::EPS * $return)
		{
			$x1_4 = (3 * $yMin + $yMax) / 4;
			$x3_4 = ($yMin + 3 * $yMax) / 4;

			if (($return > $fLeft) && ($return > $fRight))
			{
				if ($this->f($x1_4) > $return)
				{
					$yMax = ($yMin + $yMax) / 2;
					$fRight = $return;
				}
				else
				{
					if ($this->f($x3_4) > $return)
					{
						$yMin = ($yMin + $yMax) / 2;
						$fLeft = $return;
					}
					else
					{
						$yMin = $x1_4;
						$fLeft = $this->f($yMin);
						$yMax = $x3_4;
						$fRight = $this->f($yMax);
					}
				}
			}
			else
			{
				if ($return < $fLeft)
				{
					$yMax = ($yMin + $yMax) / 2;
					$fRight = $return;
				}
				else
				{
					$yMin = ($yMin + $yMax)/2;
					$fLeft = $return;
				}
			}
			$return = $this->f(($yMin + $yMax) / 2);
		}
		return $return;
	}

	public function f($x)
	{
		return 1;
	}
}