<?php
/**
 * Интерфейс форм
 *
 * @file      FormInterface.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Сбт Ноя 10 06:37:26 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Form;

use Veles\Form\Elements\ElementInterface;

/**
 * Интерфейс FormInterface
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface FormInterface
{
	/**
	 * Сохранение формы
	 */
	public function save();

	/**
	 * Добавление элемента формы
	 * @param ElementInterface $element Экземпляр элемента формы
	 * @return
	 */
	public function addElement(ElementInterface $element);

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
