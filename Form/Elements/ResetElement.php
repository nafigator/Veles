<?php
/**
 * Reset button element for forms
 *
 * @file      ResetElement.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-10-21 10:33
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Form\Elements;

use Veles\Form\Elements\AbstractElement;

/**
 * Class   ResetElement
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class ResetElement extends AbstractElement
{
	/**
	 * Rendering for reset button
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="reset">';
	}
}
