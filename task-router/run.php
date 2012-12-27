<?php
set_time_limit(0);

abstract class FrequencyFunction
{
	const EPS = 0.001;

	abstract function getY($x);

	/**
	 * Определение максимального значения f(x) в указанном диапазоне.
	 * Используется метод деления отрезка пополам.
	 * Метод рассчитан на нахождение максимума только для унимодальных функций
	 */
	public function getMaxValueOfFunction($xMinOffset, $xMaxOffset)
	{
		$yMin  = $xMinOffset;
		$yMax  = $xMaxOffset;
		$fLeft = $this->getY($yMin);
		$fRight= $this->getY($yMax);

		$return = $this->getY(($yMin + $yMax) / 2);

		while (abs($return - $fLeft) + abs($return - $fRight) > self::EPS * $return)
		{
			$x1_4 = (3 * $yMin + $yMax) / 4;
			$x3_4 = ($yMin + 3 * $yMax) / 4;

			if (($return > $fLeft) && ($return > $fRight))
			{
				if ($this->getY($x1_4) > $return)
				{
					$yMax = ($yMin + $yMax) / 2;
					$fRight = $return;
				}
				else
				{
					if ($this->getY($x3_4) > $return)
					{
						$yMin = ($yMin + $yMax) / 2;
						$fLeft = $return;
					}
					else
					{
						$yMin = $x1_4;
						$fLeft = $this->getY($yMin);
						$yMax = $x3_4;
						$fRight = $this->getY($yMax);
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
			$return = $this->getY(($yMin + $yMax) / 2);
		}
		return $return;
	}
}

class NormalFunction extends FrequencyFunction
{
	const U = 630;
	const Q = 0.2;

	public function getY($x)
	{
		$expArg = -(pow($x - self::U, 2) / (2 * pow(self::Q, 2)));
		$result = (1 / (self::Q * sqrt(2 * pi()))) * exp($expArg);
		return $result;
		//return 1;
	}
}


class Law
{
	/**
	 * Относительная точность нахождения максимума
	 */
	const EPS = 1;

	protected $_xMax;
	protected $_xMin;
	protected $_fMax;
	/**
	 * @var FrequencyFunction
	 */
	protected $_fFreq;

	/**
	 * @param $FF
	 * @param $xMinCellBound
	 * @param $xMaxCellBound
	 * @throws Exception
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
	 * Генерирует случайную величину, подчиняющуюся закону распределения,
	 * указанному в функции fFreq
	 */
	public function getNewValue($currentX)
	{
		$this->_xMin = $currentX;
		do
		{
			$newValue = $this->_xMax * $this->floatRand(0, 100);

			//$newValue = ($this->_xMax - $this->_xMin) * $this->floatRand(0, 100) + $this->_xMin;
		}
		while ($newValue > $this->_fFreq->getMaxValueOfFunction($this->_xMin, $this->_xMax));
		//while (($this->_fMax * $this->floatRand(0, 100)) < $this->_fFreq->getY($newValue));

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


	$function = new NormalFunction();
	$generator = new Law($function, 0, 530);

	for ($i = 0 ; $i < 52; $i++)
	{
		echo '[\'' . $i . '\', ' . $generator->getNewValue($i) . '],';
		//echo $generator->getNewValue($i);
	}




/*function NormalRandom ($ma, $dg)
{
    do
	{
		$U1 = 2*randomreal() - 1;
		$S2 = sqr(U1) + sqr(2*randomreal() - 1);

	}while (S2 > 1.0);


    return (sqrt(-2*log(S2)/S2) * U1 * dg + ma);

}*/



//(псевдо) нормальный закон распределения случайной величины
#include <time.h> // необходим модуль для функции time()
#include <stdlib.h>//
#include <stdio.h>

//---------- небольшой тюнинг -----------
#define randomize() srand((unsigned)time(NULL));//инициализация...
//====================================================================
/*Программа моделирует (разыгрывает) случайные величины согласно нормального
закона распределения*/



function Random()
{
	$N1rand = 101;
	$N2rand = 302;

	$x = ((double)($N1rand = (($N1rand *= 1373) % 1000919) ) / 1000919.0 + (double)($N2rand = (($N2rand *= 1528) % 1400159)) / 1400159.0 );
    return $x;
}
//---------------------------------------
define(RAND_MAX, 630);
function randomreal()
{
	$i = random();
    while($i == RAND_MAX)
		$i = random();
    return $i/ RAND_MAX;
}

//---------------------------------------

function randominteger($maxv)
{
	return random() % $maxv;
}

//---------------------------------------
function NormalRandom ($ma, $dg)
// Ma - мат.ожидание, dg - дисперсия }
{
	do
	{
		$U1 = 2*randomreal() - 1;
		$S2 = pow($U1, 2) + pow(2*randomreal() - 1, 2);
	}
	while ($S2 > 1.0);
	return (sqrt(-2 * log($S2) / $S2) * $U1 * $dg + $ma);
   /*

    do
	{
		$u = (2*randominteger(2)-1)* randomreal();
		$v = (2*randominteger(2)-1)* randomreal();

		//u = Rand();
		//v = Rand();

		$sum = $u * $u + $v * $v;

		if(($sum < 1) && ($sum > 0))
		{
			$sum = sqrt(-2*log($sum) / $sum);
		}
	}
	while ($sum < 1.0);

    return ($ma + $dg * (($u+$v) / 2) * $sum);*/

}
 вфыв

function Gauss($Mx, $Sigma)
{
	do
		$a = 2 * Random - 1;
		$b = 2 * Random - 1;
	$r = pow($a, 2) + pow($b, 2);
	while (r > 1);
	$Sq = sqrt(-2 * log($r) / $r);
	return $Mx + $Sigma * $a * $Sq;
}
//Пример использования:


//X := Gauss(0, 1);


for ($i = 0 ; $i < 52; $i++)
{
//	echo '[\'' . $i . '\', ' . NormalRandom(0, 0.2) . '],';
	//echo '[\'' . $i . '\', ' . $generator->getNewValue($i) . '],';
	//echo $generator->getNewValue($i);
}