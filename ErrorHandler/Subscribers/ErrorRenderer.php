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

use Veles\ErrorHandler\HtmlBuilders\AbstractErrorBuilder;

/**
 * Class ErrorRenderer
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ErrorRenderer implements \SplObserver
{
	/** @var  AbstractErrorBuilder */
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
	 * @return AbstractErrorBuilder
	 */
	public function getMessageBuilder()
	{
		return $this->builder;
	}

	/**
	 * @param AbstractErrorBuilder $builder
	 */
	public function setMessageBuilder(AbstractErrorBuilder $builder)
	{
		$this->builder = $builder;
	}
}
