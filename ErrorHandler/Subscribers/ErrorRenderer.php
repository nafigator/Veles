<?php
/**
 * Class for displaying errors in HTML format
 *
 * @file      ErrorRenderer.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-08-10 11:32
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler\Subscribers;

use Veles\ErrorHandler\BaseErrorHandler;
use Veles\ErrorHandler\HtmlBuilders\ErrorBuilder;

/**
 * Class ErrorRenderer
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ErrorRenderer implements \SplObserver
{
	/** @var  ErrorBuilder */
	protected $message_builder;

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param \SplSubject $subject The SplSubject notifying the observer of an update.
	 */
	public function update(\SplSubject $subject)
	{
		if (!$subject instanceof BaseErrorHandler) {
			return;
		}

		$builder = $this->getMessageBuilder();
		$builder->setHandler($subject);
		echo $builder->getHtml();
	}

	/**
	 * @return ErrorBuilder
	 */
	public function getMessageBuilder()
	{
		return $this->message_builder;
	}

	/**
	 * @param ErrorBuilder $builder
	 */
	public function setMessageBuilder(ErrorBuilder $builder)
	{
		$this->message_builder = $builder;
	}
}
