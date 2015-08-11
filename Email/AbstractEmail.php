<?php
/**
 * Базовый класс для email-сообщений
 * @file      AbstractEmail.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Втр Июл 17 21:58:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Email;

/**
 * Класс AbstractEmail
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractEmail
{
	protected $receivers = [];
	protected $headers   = '';
	protected $subject   = null;
	protected $message   = null;
	protected $from	     = null;
	protected $charset   = 'utf-8';
	protected $encoding  = 'base64';   //8bit

	/**
	 * Create message
	 */
	abstract public function init();

	/**
	 * Send emails
	 */
	public function send()
	{
		foreach ($this->receivers as $receiver) {
			mail($receiver, $this->subject, $this->message, $this->headers);
		}
	}

	/**
	 * Set message recipients
	 *
	 * @param array $receivers Emails of receivers
	 */
	public function setReceivers(array $receivers)
	{
		$this->receivers = $receivers;
	}

	/**
	 * Set email subject
	 *
	 * @param string $subject Email subject
	 */
	public function setSubject($subject)
	{
		$encoded_subj = base64_encode($subject);
		$charset = $this->getCharset();
		$this->subject = "=?$charset?B?$encoded_subj?=";
	}

	/**
	 * @return string
	 */
	public function getCharset()
	{
		return $this->charset;
	}

	/**
	 * @param string $charset
	 */
	public function setCharset($charset)
	{
		$this->charset = $charset;
	}

	/**
	 * @return string
	 */
	public function getEncoding()
	{
		return $this->encoding;
	}

	/**
	 * @param string $encoding
	 */
	public function setEncoding($encoding)
	{
		$this->encoding = $encoding;
	}
}
