<?php
/**
 * Уведомление об ошибке
 * @file    ErrMail.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Сбт Июл 21 10:59:33 2012
 * @version
 */

namespace Veles\ErrorHandler;

use SplObserver;
use Veles\Email\AbstractEmail;

/**
 * Класс ErrEmail
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ErrMail extends AbstractEmail implements SplObserver
{
	/**
	 * Инициализация параметров
	 */
	final public function init()
	{
		$this->receiver = 'poligon@tut.by';

		$this->headers  = "From: www@itvault.info\n";
		$this->headers .= 'X-Mailer: PHP/' . phpversion() . "\n";
		$this->headers .= "MIME-Version: 1.0\n";
		$this->headers .= "Content-type: text/html; charset=$this->charset \n";
		$this->headers .= "Content-Transfer-Encoding: $this->encoding";

		$this->subject  = '=?' . $this->charset . '?B?' . base64_encode('itvault.info Error') . '?=';
	}
}
