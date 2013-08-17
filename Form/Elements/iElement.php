<?php
/**
 * Интерфейс элементов формы
 * @file    iElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 14 05:36:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

use Veles\Form\AbstractForm;

/**
 * Интерфейс iElement
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iElement
{
	/**
	 * Form element validation
	 *
	 * @param AbstractForm $form Form object
	 *
	 * @return bool
	 */
	public function validate(AbstractForm $form);

	/**
	 * Check for element requirement
	 *
	 * @return bool
	 */
	public function required();

	/**
	 * Получение имени элемента
	 */
	public function getName();

	/**
	 * Отрисовка элемента
	 */
	public function render();
}
