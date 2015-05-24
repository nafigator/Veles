<?php
/**
 * Базовый класс для email-сообщений
 * @file    AbstractEmail.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Втр Июл 17 21:58:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Email;

use SplSubject;

/**
 * Класс AbstractEmail
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractEmail
{
	protected $receiver = null;
	protected $headers  = null;
	protected $subject  = null;
	protected $message  = null;
	protected $from		= null;
	protected $charset  = 'utf-8';
	protected $encoding = 'base64';   //8bit

	/**
	 * Вызов
	 * @param SplSubject $subject
	 * @internal param array $vars Набор переменных
	 */
	public function update(SplSubject $subject)
	{
		/** @noinspection PhpUndefinedMethodInspection */
		$this->message = base64_encode($subject->getMessage());
		$this->init();
		$this->send();
	}

	/**
	 * Создание сообщения
	 */
	abstract public function init();

	/**
	 * Отправка письма
	 */
	protected function send()
	{
		mail($this->receiver, $this->subject, $this->message, $this->headers);
	}

	/**
	 * @param string $receiver Email of receiver
	 */
	public function setReceiver($receiver)
	{
		$this->receiver = $receiver;
	}
}
