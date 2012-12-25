<?php

class EmulateExcel extends CWidget
{
	/** Текстовый формат ячеки */
	const CELL_FORMAT_TEXT    = 'format-text';
	/** Числовой формат ячеки */
	const CELL_FORMAT_NUMBER  = 'format-number';
	/** Процентный формат ячеки */
	const CELL_FORMAT_PERCENT = 'format-percent';

	public $htmlOptions = array();
	public $rowCharsList = array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	public $rowChars;
	public $startRow = 'A';

	public $startCol = 1;
	public $data;

	private $_offsetCol = 8;
	private $_offsetRow = 4;
	private $_headerHtmlOptions;

	public $tableClass = 'excel-table';
	public $headerClass = false;

	public $showHeaders = true;

	public $showFormulaBar = false;
	public $resizable = false;

	public $f;
	public $lockedCells = false;
	public $dataProvider;



	public function init()
	{
		parent::init();
		$this->_headerHtmlOptions = $this->headerClass === false ? array() : array('class'=>$this->headerClass);

		$this->rowChars = array_slice($this->rowCharsList, $this->_offsetRow);
		if ($this->rowChars[0] != '')
			array_unshift($this->rowChars, '');

		$this->tableClass = $this->tableClass . ($this->lockedCells === true ? ' locked' : '');
	}

	public function run()
	{
		$assetsDir = __DIR__  . '/assets';
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->getAssetManager()->publish($assetsDir . '/js.js'), CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->getAssetManager()->publish($assetsDir . '/css.css'));

		$headerHtmlOptions = $this->headerClass === false ? array('style'=>'width: 20px;') : array('class'=>$this->headerClass, 'style'=>'width: 20px;');

		$html = CHtml::openTag('table', array('class'=>$this->tableClass));
		foreach ($this->data as $key => $cols)
		{
			if ($key == 0 && $this->showHeaders)
				$html .= $this->renderHeader(count($cols));

			$html .= CHtml::openTag('tr');

			if ($this->showHeaders)
				$html .= CHtml::openTag('th', $headerHtmlOptions) . ($key + 1 + $this->_offsetCol) . CHtml::closeTag('th');

			foreach ($cols as $index => $row)
			{
				$format = $this->getCellFormat($row);
				if ($key == 0 && $index == 0)
					$format .= ' selected';

				$html = $html
					. CHtml::openTag('td', array('style'=>'position: relative;', 'class'=>$format, 'data-position-x'=>$index, 'data-position-y'=>$key))
					. CHtml::openTag('div')
					. $row
					. CHtml::tag('span')
					. CHtml::closeTag('div')
					. CHtml::closeTag('td');
			}
			$html .= CHtml::closeTag('tr') . "\r\n";
		}
		echo  $html . CHtml::closeTag('table');
	}

	/**
	 * Определяет формат ячейки по её содержимому
	 * @param mixed $value значение ячеки
	 * @return string формат
	 */
	protected function getCellFormat($value)
	{
		$length = mb_strlen($value, Yii::app()->charset);

		$percentCondition = false;
		if (strpos($value, '%') === ($length - 1))
		{
			$tmpValue = mb_substr($value, 0, $length - 1);
			if (is_numeric($tmpValue))
				$percentCondition = true;
		}

		if ($percentCondition)
			$format = self::CELL_FORMAT_PERCENT;
		elseif (is_numeric($value))
			$format = self::CELL_FORMAT_NUMBER;
		else $format = self::CELL_FORMAT_TEXT;
		return $format;
	}

	protected function renderHeader($countCols)
	{
		$countCols++;
		$html = CHtml::openTag('tr');
		for ($i = 0; $i < $countCols; $i++)
			$html .= CHtml::openTag('th', $this->_headerHtmlOptions) . $this->rowChars[$i] . CHtml::closeTag('th');
		return $html . CHtml::closeTag('tr');
	}
}


