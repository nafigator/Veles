<?php
/**
 * @file      ErrorRenderer.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-10 11:32
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler\Subscribers;

/**
 * Class ErrorRenderer
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ErrorRenderer implements \SplObserver
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
		echo $this->builder->getHtml();
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
}
