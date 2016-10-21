<?php
/**
 * Select form element
 *
 * @file      SelectElement.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
 * @date      Чтв Ноя 29 22:09:01 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Form\Elements;

/**
 * Class SelectElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class SelectElement extends AbstractElement
{
	protected $option_id   = 'id';
	protected $option_name = 'name';

	/**
	 * Element rendering
	 */
	public function render()
	{
		$html = '<select' . $this->attributes() . '>';
		$idx  = $this->option_id;
		$name = $this->option_name;

		foreach ($this->options as $option) {
			$selected = '';

			if (isset($this->selected) && $option[$idx] === $this->selected) {
				$selected = ' selected="true" ';
			}

			$html .= "<option $selected value=\"{$option[$idx]}\">
						{$option[$name]}
					  </option>";
		}

		$html .= '</select>';

		return $html;
	}


	/**
	 * Set select options
	 *
	 * @param $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
	}
}
