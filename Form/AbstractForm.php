<?php
/**
 * Base class for forms
 *
 * @file      AbstractForm.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Вск Авг 12 10:30:52 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Form;

use Form\Elements\ResetElement;
use Veles\Cache\Cache;
use Veles\Form\Elements\ButtonElement;
use Veles\Form\Elements\HiddenElement;
use Veles\Form\Elements\ElementInterface;
use Veles\Form\Elements\SubmitElement;
use Veles\Validators\RegExValidator;

/**
 * Class AbstractForm
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractForm implements FormInterface
{
	protected $method   = 'post';
	protected $template = null;
	protected $data     = null;
	protected $sid      = null;
	protected $name     = null;
	protected $action   = null;
	protected $elements = [];

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
	protected function init()
	{
		$input      = ('get' === $this->method) ? INPUT_GET : INPUT_POST;
		$this->data = filter_input_array($input, FILTER_UNSAFE_RAW);
		$this->sid  = md5(uniqid('', true));

		$params = [
			'validator'  => new RegExValidator('/^[a-f\d]{32}$/'),
			'required'   => true,
			'attributes' => ['name' => 'sid', 'value' => $this->sid]
		];
		$this->addElement(new HiddenElement($params));
	}

	/**
	 * Add form element
	 * @param ElementInterface $element Form element
	 * @return void
	 */
	public function addElement(ElementInterface $element)
	{
		$this->elements[] = $element;
	}

	/**
	 * Form validation
	 * @return bool
	 */
	public function valid()
	{
		/** @var ElementInterface $element*/
		foreach ($this->elements as $element) {
			switch (true) {
				case $element instanceof ButtonElement:
				case $element instanceof ResetElement:
				case $element instanceof SubmitElement:
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
	public function submitted()
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
	public function cleanup()
	{
		$key = $this->name . $this->data['sid'];
		Cache::del($key);
	}

	/**
	 * Form output
	 * @return string
	 */
	public function __toString()
	{
		$elements = $tpl = [];
		$output   = file_get_contents($this->template);

		/** @var ElementInterface $element */
		foreach ($this->elements as $number => $element) {
			$elements[] = $element->render();
			$tpl[]      = "#$number#";
		}

		$tpl      = array_merge($tpl, ["#method#", "#action#", "#name#"]);
		$elements = array_merge(
			$elements,
			[
				$this->method,
				$this->action,
				$this->name
			]
		);

		$this->saveSid();

		return str_replace($tpl, $elements, $output);
	}

	/**
	 * Return form security id
	 *
	 * Can be used for refresh sid after ajax-request
	 *
	 * @return string
	 */
	public function getSid()
	{
		return $this->sid;
	}

	/**
	 * Save form security id to cache
	 * @return bool
	 */
	public function saveSid()
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
	public function getData($name)
	{
		return (isset($this->data[$name])) ? $this->data[$name] : null;
	}
}
