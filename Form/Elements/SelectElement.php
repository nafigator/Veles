<?php
/**
 * Select form element
 * @file      SelectElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Чтв Ноя 29 22:09:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Class SelectElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class SelectElement extends AbstractElement
{
	/**
	 * Element rendering
	 */
	public function render()
	{
		$html = '<select' . $this->attributes() . '>';

		$idx = isset($this->option_id)
			? $this->option_id
			: 'id';
		$name = isset($this->option_name)
			? $this->option_name
			: 'name';

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
