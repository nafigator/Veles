<?php
/**
 * Интерфейс форм
 *
 * @file      iForm.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Сбт Ноя 10 06:37:26 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Form;

use Veles\Form\Elements\iElement;

/**
 * Интерфейс iForm
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface iForm
{
	/**
	 * Сохранение формы
	 */
	public function save();

	/**
	 * Добавление элемента формы
	 * @param iElement $element Экземпляр элемента формы
	 * @return
	 */
	public function addElement(iElement $element);

	/**
	 * Валидатор формы
	 */
	public function valid();

	/**
	 * Проверка была ли отправлена форма
	 */
	public function submitted();

	/**
	 * Вывод формы
	 */
	public function __toString();
}
