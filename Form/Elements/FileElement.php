<?php
/**
 * Class for upload file form field
 *
 * @file    FileElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-07-21 16:55
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

use Veles\Form\AbstractForm;

/**
 * Class FileElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class FileElement extends AbstractElement
{
	/**
	 * Rendering upload form field
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="file">';
	}

	/**
	 * Element validation
	 *
	 * @param AbstractForm $form Form object
	 *
	 * @return bool
	 */
	public function validate(AbstractForm $form)
	{
		$element_name = $this->getName();

		if (!isset($_FILES[$element_name])) {
			return !$this->required();
		}

		if (!$this->validator) {
			return true;
		}

		return $this->validator->check($element_name);
	}
}
