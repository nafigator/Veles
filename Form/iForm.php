<?php
/**
 * Интерфейс форм
 * @file    iForm.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Ноя 10 06:37:26 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form;

use Veles\Form\Elements\iElement;

/**
 * Интерфейс iForm
 * @author  Yancharuk Alexander <alex@itvault.info>
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
