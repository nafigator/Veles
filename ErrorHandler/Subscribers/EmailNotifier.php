<?php
/**
 * Class email-notifier about errors
 *
 * @file      EmailNotifier.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-06-06 20:16
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler\Subscribers;

use Veles\Email\AbstractEmail;
use Veles\ErrorHandler\HtmlBuilders\AbstractBuilder;

/**
 * Class EmailNotifier
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class EmailNotifier extends AbstractEmail implements \SplObserver
{
	/** @var  AbstractBuilder */
	protected $message_builder;

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param \SplSubject $subject The SplSubject notifying the observer of an update.
	 */
	public function update(\SplSubject $subject)
	{
		$builder = $this->getMessageBuilder();
		$builder->setHandler($subject);
		$this->message = base64_encode($builder->getHtml());
		$this->init();
		$this->send();
	}

	/**
	 * @return AbstractBuilder
	 */
	public function getMessageBuilder()
	{
		return $this->message_builder;
	}

	/**
	 * @param AbstractBuilder $builder
	 */
	public function setMessageBuilder(AbstractBuilder $builder)
	{
		$this->message_builder = $builder;
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
