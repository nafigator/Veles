<?php
/**
 * @file    EmailNotifier.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-06-06 20:16
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler;

use Veles\Email\AbstractEmail;

/**
 * Class EmailNotifier
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class EmailNotifier extends AbstractEmail implements \SplObserver
{
	/** @var  AbstractErrorHtmlBuilder */
	protected $builder;

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param \SplSubject $subject The SplSubject notifying the observer of an update.
	 */
	public function update(\SplSubject $subject)
	{
		$this->builder->setHandler($subject);
		$this->message = base64_encode($this->builder->getHtml());
		$this->init();
		$this->send();
	}

	/**
	 * @return AbstractErrorHtmlBuilder
	 */
	public function getMessageBuilder()
	{
		return $this->builder;
	}

	/**
	 * @param AbstractErrorHtmlBuilder $builder
	 */
	public function setMessageBuilder(AbstractErrorHtmlBuilder $builder)
	{
		$this->builder = $builder;
	}

	/**
	 * Email initialization
	 */
	public function init()
	{
		if (null === $this->receivers) {
			$msg = 'Error notification recipients not set!';
			throw new \Exception($msg);
		}

		$charset  = $this->getCharset();
		$encoding = $this->getEncoding();

		$this->from		= isset($_SERVER['SERVER_NAME'])
			? $_SERVER['SERVER_NAME']
			: $_SERVER['SERVER_ADDR'];
		$this->headers .= 'X-Mailer: PHP/' . phpversion() . "\n";
		$this->headers .= "MIME-Version: 1.0\n";
		$this->headers .= "Content-type: text/html; charset=$charset\n";
		$this->headers .= "Content-Transfer-Encoding: $encoding";
	}

	/**
	 * Set additional email headers
	 *
	 * @param string $header
	 */
	public function addHeaders($header)
	{
		$this->headers .= $header . "\n";
	}
}
