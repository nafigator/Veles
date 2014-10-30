<?php
/**
 * Контроллер для теста Application
 * @file    Home.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Янв 25 05:49:20 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Controllers\Frontend;

/**
 * Класс Home
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Home
{
	/**
	 * Метод вызываемый при запросе /index.html
	 */
	public function index()
	{
		return array('a' => 'Test', 'b' => 'complete', 'c' => 'Hello');
	}
}
