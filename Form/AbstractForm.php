<?php
/**
 * Base class for forms
 * @file    AbstractForm.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Авг 12 10:30:52 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form;

use Veles\Cache\Cache;
use Veles\Form\Elements\ButtonElement;
use Veles\Form\Elements\HiddenElement;
use Veles\Form\Elements\FileElement;
use Veles\Form\Elements\iElement;
use Veles\Form\Elements\SubmitElement;
use Veles\Validators\RegEx;
use Veles\View\View;

/**
 * Class AbstractForm
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class AbstractForm implements iForm
{
	protected $method   = 'post';
	protected $template = null;
	protected $data     = null;
	protected $sid      = null;
	protected $name     = null;
	protected $action   = null;
	protected $elements = array();

	/**
	 * Constructor
	 * @param mixed $data Optional data for form generation
	 */
	abstract public function __construct($data = false);

	/**
	 * Form save
	 */
	abstract public function save();

	/**
	 * Default values initialization
	 */
	final protected function init()
	{
		$this->data = ('get' === $this->method) ? $_GET : $_POST;
		$this->sid  = md5(mt_rand());

		$params = array(
			'validator'  => new RegEx('/^[a-f\d]{32}$/'),
			'required'   => true,
			'attributes' => array('name' => 'sid', 'value' => $this->sid)
		);
		$this->addElement(new HiddenElement($params));
	}

	/**
	 * Add form element
	 * @param iElement $element Form element
	 * @return void
	 */
	final public function addElement(iElement $element)
	{
		$this->elements[] = $element;
	}

	/**
	 * Form validation
	 * @return bool
	 */
	final public function valid()
	{
		/** @var iElement $element*/
		foreach ($this->elements as $element) {
			switch (true) {
				case $element instanceof ButtonElement:
				case $element instanceof SubmitElement:
					continue;
					break;
				default:
					if (!$element->validate($this)) {
						return false;
					}
					break;
			}
		}

		return true;
	}

	/**
	 * Check is form submitted by security key presence
	 * @return bool
	 */
	final public function submitted()
	{
		if (!isset($this->data['sid'])) {
			return false;
		}

		$key = $this->name . $this->data['sid'];

		if (!Cache::get($key)) {
			return false;
		}

		return true;
	}

	/**
	 * Security key cleanup
	 */
	final public function cleanup()
	{
		$key = $this->name . $this->data['sid'];
		Cache::del($key);
	}

	/**
	 * Form output
	 * @return string
	 */
	final public function __toString()
	{
		$elements = $tpl = array();
		$output   = View::get($this->template);

		/** @var iElement $element */
		foreach ($this->elements as $number => $element) {
			$elements[] = $element->render($this);
			$tpl[]      = "#$number#";
		}

		$tpl      = array_merge($tpl, array("#method#", "#action#", "#name#"));
		$elements = array_merge(
			$elements,
			array(
				$this->method,
				$this->action,
				$this->name
			)
		);

		$this->saveSid();

		return str_replace($tpl, $elements, $output);
	}

	/**
	 * Return form seciruty id
	 *
	 * Can be used for refresh sid after ajax-request
	 *
	 * @return string
	 */
	final public function getSid()
	{
		return $this->sid;
	}

	/**
	 * Save form security id to cache
	 * @return bool
	 */
	final public function saveSid()
	{
		return Cache::set($this->name . $this->sid, true, 7200);
	}

	/**
	 * Get data by element name
	 *
	 * @param string $name Element name
	 *
	 * @return null|string
	 */
	final public function getData($name)
	{
		return (isset($this->data[$name])) ? $this->data[$name] : null;
	}
}
