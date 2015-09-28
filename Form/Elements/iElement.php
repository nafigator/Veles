<?php
/**
 * Интерфейс элементов формы
 *
 * @file      iElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Авг 14 05:36:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Form\Elements;

use Veles\Form\AbstractForm;

/**
 * Интерфейс iElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
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
